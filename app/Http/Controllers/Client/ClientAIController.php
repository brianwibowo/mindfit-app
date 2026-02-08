<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ClientAIController extends Controller
{
    public function index()
    {
        return view('client.ai.index');
    }

    public function analyze(Request $request)
    {
        // 1. Validate Input
        $request->validate([
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'usia' => 'required|numeric',
            'tinggi' => 'required|numeric',
            'berat' => 'required|numeric',
            'riwayat_cedera' => 'nullable|array',
            'frekuensi_olahraga' => 'required|string',
            'pengalaman_gym' => 'required|string',
            'pola_makan' => 'required|string',
            'target_utama' => 'required|string',
            'keluhan' => 'nullable|string',
        ]);

        // 2. Format Data for n8n API
        // Mapping checkbox array to comma-separated string
        $riwayatKesehatan = $request->riwayat_cedera ? implode(', ', $request->riwayat_cedera) : 'Tidak Ada';

        $payload = [
            "nama" => $request->nama,
            "usia" => (int) $request->usia,
            "tinggi" => (int) $request->tinggi,
            "berat" => (int) $request->berat,
            "riwayatKesehatan" => $riwayatKesehatan,
            "frekuensiOlahraga" => $request->frekuensi_olahraga,
            "polaMakan" => $request->pola_makan,
            "targetUtama" => $request->target_utama,
            "keluhan" => $request->keluhan ?? "Tidak ada",
            // Extra data that might be useful for local logic or future API updates
            "jenis_kelamin" => $request->jenis_kelamin,
            "pengalaman" => $request->pengalaman_gym
        ];

        // 3. Call API
        $apiUrl = 'https://n8n.sejarah-bot.datains.id/webhook/mindfit-fix';

        try {
            $response = Http::timeout(10)->post($apiUrl, $payload);

            if ($response->successful()) {
                $result = $response->json();

                // If API returns valid data
                if (isset($result['rekomendasi_paket'])) {

                    // 1. Calculate stats locally (API might not return them)
                    $stats = $this->calculateStats($payload);
                    $result['bmr'] = $stats['bmr'];
                    $result['tdee'] = $stats['tdee'];

                    // 2. Map API String to Local Package Details
                    // Expected API String: "MindFit Starter Plus" or "Starter Plus"
                    $apiRec = strtolower($result['rekomendasi_paket']);
                    $key = 'plus'; // Default fallback

                    if (str_contains($apiRec, 'basic'))
                        $key = 'basic';
                    if (str_contains($apiRec, 'complete') || str_contains($apiRec, 'squad'))
                        $key = 'complete';

                    $packages = $this->getPackageDictionary();
                    $result['details'] = $packages[$key] ?? $packages['plus'];

                    // Ensure format consistency
                    if (!isset($result['pesan']))
                        $result['pesan'] = $result['details']['message'];

                } else {
                    $result = $this->fallbackLogic($payload);
                }
            } else {
                $result = $this->fallbackLogic($payload);
            }
        } catch (\Exception $e) {
            $result = $this->fallbackLogic($payload);
        }

        // 4. Calculate BMI for Visualization (Local)
        $bmi = $payload['berat'] / (($payload['tinggi'] / 100) * ($payload['tinggi'] / 100));
        $result['bmi_value'] = number_format($bmi, 1);
        $result['bmi_status'] = $this->getBMIStatus($bmi);

        // 5. Save to Database
        try {
            $analysis = \App\Models\AiAnalysis::create([
                'user_id' => Auth::id(),
                'name' => $payload['nama'],
                'gender' => $payload['jenis_kelamin'],
                'age' => $payload['usia'],
                'height' => $payload['tinggi'],
                'weight' => $payload['berat'],
                'health_history' => $payload['riwayatKesehatan'],
                'exercise_frequency' => $payload['frekuensiOlahraga'],
                'gym_experience' => $payload['pengalaman'],
                'diet_pattern' => $payload['polaMakan'],
                'target' => $payload['targetUtama'],
                'complaint' => $payload['keluhan'],
                'bmi_score' => (float) $result['bmi_value'],
                'bmi_status' => $result['bmi_status'],
                'bmr' => $result['bmr'] ?? null,
                'tdee' => $result['tdee'] ?? null,
                'recommendation_package' => $result['rekomendasi_paket'],
                'ai_diagnosis' => $result['pesan'],
                'recommendation_data' => $result['details'] ?? null,
            ]);

            // Redirect to the history detail view (Result Page)
            return redirect()->route('client.ai.show', $analysis->id);

        } catch (\Exception $e) {
            // If DB save fails, show result directly but warn or just show
            // \Log::error($e->getMessage());
            return view('client.ai.result', compact('result', 'payload'));
        }
    }

    private function fallbackLogic($data)
    {
        // 1. Calculate Stats
        $stats = $this->calculateStats($data);

        // 2. Determine Package Key
        $freq = $data['frekuensiOlahraga'];
        $exp = $data['pengalaman'];
        $goal = $data['targetUtama'];
        $bmi = $data['berat'] / (($data['tinggi'] / 100) * ($data['tinggi'] / 100));

        $paketKey = 'plus'; // Default

        // BASIC
        if (str_contains($freq, '0x') || $exp == 'Belum Pernah') {
            $paketKey = 'basic';
        }

        // COMPLETE
        if (str_contains($freq, '3x') || $goal == 'Muscle Gain' || $bmi > 30) {
            $paketKey = 'complete';
        }

        // RISK CHECK
        if (str_contains(strtolower($data['riwayatKesehatan']), 'jantung') || str_contains(strtolower($data['riwayatKesehatan']), 'cedera parah')) {
            return [
                'rekomendasi_paket' => 'Konsultasi Khusus',
                'pesan' => "Demi keamanan, kondisi medismu butuh penanganan spesifik. Mari ngobrol langsung dengan Coach (Gratis).",
                'bmr' => $stats['bmr'],
                'tdee' => $stats['tdee'],
                'details' => null
            ];
        }

        $packages = $this->getPackageDictionary();
        $selected = $packages[$paketKey];

        return [
            'rekomendasi_paket' => 'MindFit ' . $selected['name'],
            'pesan' => $selected['message'],
            'bmr' => $stats['bmr'],
            'tdee' => $stats['tdee'],
            'details' => $selected
        ];
    }

    private function calculateStats($data)
    {
        $weight = $data['berat'];
        $height = $data['tinggi'];
        $age = $data['usia'];
        $gender = $data['jenis_kelamin'];

        if ($gender == 'Laki-laki') {
            $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) + 5;
        } else {
            $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) - 161;
        }

        $freq = $data['frekuensiOlahraga'];
        $multiplier = 1.2;
        if (str_contains($freq, '1-2x'))
            $multiplier = 1.375;
        if (str_contains($freq, '3x'))
            $multiplier = 1.55;

        return [
            'bmr' => round($bmr),
            'tdee' => round($bmr * $multiplier)
        ];
    }

    private function getPackageDictionary()
    {
        return [
            'basic' => [
                'name' => 'STARTER BASIC',
                'target' => 'Pemula (Adaptasi)',
                'freq' => '4 Sesi / bulan (1x seminggu)',
                'duration' => '45–60 Menit',
                'type' => 'Full Body (Adaptasi Ringan)',
                'goal' => 'Bangun Kebiasaan (Habit)',
                'nutrition' => 'Estimasi Kalori Dasar',
                'monitoring' => 'Saat sesi latihan',
                'price' => 'Rp 450.000',
                'message' => "Tubuhmu butuh adaptasi. Kita mulai dari membangun pondasi gerak dan metabolisme dasar."
            ],
            'plus' => [
                'name' => 'STARTER PLUS',
                'target' => 'Pemula / Fat Loss',
                'freq' => '8 Sesi / bulan (2x seminggu)',
                'duration' => '60 Menit',
                'type' => 'Full Body (Terstruktur)',
                'goal' => 'Fat Loss Awal & Stamina',
                'nutrition' => 'Rekomendasi Makro Simpel',
                'monitoring' => 'Evaluasi Mingguan',
                'price' => 'Rp 850.000',
                'message' => "Pilihan paling seimbang! Frekuensi 2x seminggu cukup untuk memicu pembakaran lemak tanpa membuatmu kaget."
            ],
            'complete' => [
                'name' => 'STARTER COMPLETE',
                'target' => 'Overweight / Serius',
                'freq' => '12 Sesi / bulan (3x seminggu)',
                'duration' => '60 Menit',
                'type' => 'Full Body + Focus Area',
                'goal' => 'Fat Loss, Postur, & Strength',
                'nutrition' => 'Personal Meal Plan Harian',
                'monitoring' => 'Full Monitoring (Daily)',
                'price' => 'Rp 1.250.000',
                'message' => "Komitmen tinggi menghasilkan hasil maksimal. Dengan 3x seminggu dan meal plan, targetmu akan tercapai lebih cepat."
            ]
        ];
    }

    public function history()
    {
        $analyses = \App\Models\AiAnalysis::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('client.ai.history', compact('analyses'));
    }

    public function show($id)
    {
        $analysis = \App\Models\AiAnalysis::where('user_id', Auth::id())->findOrFail($id);

        // Reconstruct payload and result for the view
        $payload = [
            'nama' => $analysis->name,
            'usia' => $analysis->age,
            'tinggi' => $analysis->height,
            'berat' => $analysis->weight,
            'riwayatKesehatan' => $analysis->health_history,
            'frekuensiOlahraga' => $analysis->exercise_frequency,
            'polaMakan' => $analysis->diet_pattern,
            'targetUtama' => $analysis->target,
            'keluhan' => $analysis->complaint,
            'jenis_kelamin' => $analysis->gender,
            'pengalaman' => $analysis->gym_experience,
        ];

        $result = [
            'bmi_value' => $analysis->bmi_score,
            'bmi_status' => $analysis->bmi_status,
            'bmr' => $analysis->bmr,
            'tdee' => $analysis->tdee,
            'rekomendasi_paket' => $analysis->recommendation_package,
            'pesan' => $analysis->ai_diagnosis,
            'details' => $analysis->recommendation_data,
        ];

        return view('client.ai.result', compact('result', 'payload'));
    }

    private function getBMIStatus($bmi)
    {
        if ($bmi < 18.5)
            return 'Underweight';
        if ($bmi >= 18.5 && $bmi < 24.9)
            return 'Normal';
        if ($bmi >= 25 && $bmi < 29.9)
            return 'Overweight';
        return 'Obesity';
    }
}
