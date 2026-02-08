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
        $apiUrl = 'https://n8n.sejarah-bot.datains.id/webhook/31b56c1f-9626-474e-9736-f8dbf68bfbb7';

        try {
            $response = Http::timeout(10)->post($apiUrl, $payload);

            if ($response->successful()) {
                $check = $response->json();

                // New API format: [ { "output": "..." } ]
                if (isset($check[0]['output'])) {
                    $output = $check[0]['output'];
                    $result = [];

                    // 1. Calculate Stats Locally
                    $stats = $this->calculateStats($payload);
                    $result['bmr'] = $stats['bmr'];
                    $result['tdee'] = $stats['tdee'];

                    // 2. Parse Package from Output String
                    // Look for patterns like "MINDFIT STARTER (Basic)" or just keywords
                    $lowerOutput = strtolower($output);
                    $key = 'plus'; // Default fallback

                    if (str_contains($lowerOutput, 'starter (basic)') || str_contains($lowerOutput, 'starter basic')) {
                        $key = 'basic';
                    } elseif (str_contains($lowerOutput, 'starter (complete)') || str_contains($lowerOutput, 'starter complete')) {
                        $key = 'complete';
                    } elseif (str_contains($lowerOutput, 'squad')) {
                        // If Squad is suggested, we might stick to Plus or define a Squad key, 
                        // but for now let's map to Basic/Plus based on freq or just default to Plus if vague.
                        // Or create a 'squad' entry? Let's stick to the 3 main ones for web app consistency
                        $key = 'basic';
                    }

                    // Attach Details
                    $packages = $this->getPackageDictionary();
                    $result['details'] = $packages[$key] ?? $packages['plus'];

                    // Set Result Keys
                    $result['rekomendasi_paket'] = 'MindFit ' . $result['details']['name'];

                    // Parse Markdown & Fix Name
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



    private function parseMarkdown($text, $userName)
    {
        // 1. Fix Name Placeholder
        $text = str_replace(['=User', 'User', '= User'], $userName, $text);

        // 2. Headings (### Header)
        $text = preg_replace('/^### (.*)$/m', '<h5 class="fw-bold text-primary mt-3">$1</h5>', $text);

        // 3. Bold (**text**)
        $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);

        // 4. Bullet Points (* text) -> Convert to a cleaner list style or just bullet char
        // Regex to find lines starting with "* " and replacing with a div/span dot
        $text = preg_replace('/^\* (.*)$/m', '<div class="d-flex align-items-start mb-1"><i class="fas fa-check-circle text-success me-2 mt-1"></i> <span>$1</span></div>', $text);

        // 5. Horizontal Rule (---)
        $text = preg_replace('/^---$/m', '<hr class="my-3 opacity-25">', $text);

        // 6. Convert remaining newlines to <br> if not already handled by block elements? 
        // Actually, we should just use nl2br on the whole thing, but we introduced HTML tags. 
        // So let's just do simple replacement of \n
        $text = nl2br($text);

        return $text;
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
