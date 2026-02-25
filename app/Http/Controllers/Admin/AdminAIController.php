<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiAnalysis;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class AdminAIController extends Controller
{
    public function index()
    {
        $analyses = AiAnalysis::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.ai.index', compact('analyses'));
    }

    public function create()
    {
        return view('admin.ai.create');
    }

    public function store(Request $request)
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
            "jenis_kelamin" => $request->jenis_kelamin,
            "pengalaman" => $request->pengalaman_gym
        ];

        // 3. Call API (With Fallback)
        $apiUrl = 'https://n8n.sejarah-bot.datains.id/webhook/31b56c1f-9626-474e-9736-f8dbf68bfbb7';

        try {
            $response = Http::timeout(10)->post($apiUrl, $payload);

            if ($response->successful()) {
                $check = $response->json();

                // New API format: [ { "output": "..." } ]
                if (isset($check[0]['output'])) {
                    $output = $check[0]['output'];
                    $result = [];

                    // Enrich Data
                    $stats = $this->calculateStats($payload);
                    $result['bmr'] = $stats['bmr'];
                    $result['tdee'] = $stats['tdee'];

                    // Parse Package
                    $lowerOutput = strtolower($output);
                    $key = 'plus';
                    if (str_contains($lowerOutput, 'starter (basic)') || str_contains($lowerOutput, 'starter basic')) {
                        $key = 'basic';
                    } elseif (str_contains($lowerOutput, 'starter (complete)') || str_contains($lowerOutput, 'starter complete')) {
                        $key = 'complete';
                    }

                    $packages = $this->getPackageDictionary();
                    $result['details'] = $packages[$key] ?? $packages['plus'];

                    $result['rekomendasi_paket'] = 'MindFit ' . $result['details']['name'];
                    $result['pesan'] = $this->parseMarkdown($output, $payload['nama']);

                } else {
                    $result = $this->fallbackLogic($payload);
                }
            } else {
                $result = $this->fallbackLogic($payload);
            }
        } catch (\Exception $e) {
            $result = $this->fallbackLogic($payload);
        }

        // 4. Calculate BMI Local
        $bmi = $payload['berat'] / (($payload['tinggi'] / 100) * ($payload['tinggi'] / 100));
        $result['bmi_value'] = number_format($bmi, 1);
        $result['bmi_status'] = $this->getBMIStatus($bmi);

        // 5. Save to Database (As Admin User)
        try {
            $analysis = AiAnalysis::create([
                'user_id' => Auth::id(), // Admin's ID
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

            return redirect()->route('admin.ai.show', $analysis->id);

        } catch (\Exception $e) {
            // If save failed, technically we should show error, but let's just dump valid result for now to debug if needed
            // For admin, let's throw error to see it
            throw $e;
        }
    }

    private function fallbackLogic($data)
    {
        $stats = $this->calculateStats($data);
        $freq = $data['frekuensiOlahraga'];
        $exp = $data['pengalaman'];
        $goal = $data['targetUtama'];
        $weight = $data['berat'];
        $height = $data['tinggi'];
        $bmi = $weight / (($height / 100) * ($height / 100));

        $paketKey = 'plus';

        if (str_contains($freq, '0x') || $exp == 'Belum Pernah') {
            $paketKey = 'basic';
        }

        if (str_contains($freq, '3x') || $goal == 'Muscle Gain' || $bmi > 30) {
            $paketKey = 'complete';
        }

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

    private function parseMarkdown($text, $userName)
    {
        // 1. Fix Name Placeholder
        $text = str_replace(['=User', 'User', '= User'], $userName, $text);

        // 2. Headings (### Header)
        $text = preg_replace('/^### (.*)$/m', '<h5 class="fw-bold text-primary mt-3">$1</h5>', $text);

        // 3. Bold (**text**)
        $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);

        // 4. Bullet Points (* text)
        $text = preg_replace('/^\* (.*)$/m', '<div class="d-flex align-items-start mb-1"><i class="fas fa-check-circle text-success me-2 mt-1"></i> <span>$1</span></div>', $text);

        // 5. Horizontal Rule (---)
        $text = preg_replace('/^---$/m', '<hr class="my-3 opacity-25">', $text);

        $text = nl2br($text);

        return $text;
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
                'price' => 'Rp 799.400',
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
                'price' => 'Rp 1.518.800',
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
                'price' => 'Rp 2.158.200',
                'message' => "Komitmen tinggi menghasilkan hasil maksimal. Dengan 3x seminggu dan meal plan, targetmu akan tercapai lebih cepat."
            ]
        ];
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

    public function show($id)
    {
        $analysis = AiAnalysis::with('user')->findOrFail($id);

        // Reconstruct for view (similar to client show, but maybe with user info)
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

        return view('admin.ai.show', compact('analysis', 'result', 'payload'));
    }
}
