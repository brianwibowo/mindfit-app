<x-app-layout>
    <x-slot name="header">Detail Analisa AI: {{ $analysis->name }}</x-slot>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="mb-3">
                <a href="{{ route('admin.ai.index') }}" class="btn btn-secondary btn-sm btn-round">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                </a>
            </div>

            {{-- Include the Result Card (Reusing reuse logic visually) --}}
            {{-- Since we passed $result and $payload, we can actually just replicate the Client Result view content
            here but wrapped in Admin context --}}

            <div class="card card-round">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0 fw-bold"><i class="fas fa-clipboard-check me-2"></i> HASIL ANALISA:
                        {{ strtoupper($analysis->name) }}
                    </h3>
                </div>
                <div class="card-body">

                    {{-- Admin Note --}}
                    <div class="alert alert-warning mb-4">
                        <strong><i class="fas fa-info-circle me-1"></i> Info Admin:</strong>
                        User ini {{ $analysis->user ? 'terdaftar sebagai member' : 'adalah tamu' }}.
                        <br>
                        Email: {{ $analysis->user->email ?? '-' }} | No HP: {{ $analysis->user->phone_number ?? '-' }}
                    </div>

                    {{-- User Stats --}}
                    <div class="row text-center mb-4">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="border p-3 rounded bg-light h-100">
                                <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.8rem;">BMI Check
                                </h6>
                                <h2 class="fw-bold mb-0 text-primary">{{ $result['bmi_value'] }}</h2>
                                <span
                                    class="badge mt-2 {{ $result['bmi_status'] == 'Normal' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $result['bmi_status'] }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="border p-3 rounded bg-light h-100">
                                <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.8rem;">Kalori BMR
                                </h6>
                                <h2 class="fw-bold mb-0 text-info">{{ $result['bmr'] ?? '-' }}</h2>
                                <small class="text-muted">kkal/hari</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border p-3 rounded bg-light h-100">
                                <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size: 0.8rem;">TDEE</h6>
                                <h2 class="fw-bold mb-0 text-success">{{ $result['tdee'] ?? '-' }}</h2>
                                <small class="text-muted">kkal/hari</small>
                            </div>
                        </div>
                    </div>

                    {{-- Full Data Accordion --}}
                    <div class="accordion mb-4" id="accordionData">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne">
                                    <i class="fas fa-list me-2"></i> Lihat Data Lengkap Input User
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionData">
                                <div class="accordion-body">
                                    <table class="table table-bordered table-sm">
                                        <tr>
                                            <th width="30%">Jenis Kelamin</th>
                                            <td>{{ $payload['jenis_kelamin'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Usia</th>
                                            <td>{{ $payload['usia'] }} Tahun</td>
                                        </tr>
                                        <tr>
                                            <th>Tinggi / Berat</th>
                                            <td>{{ $payload['tinggi'] }} cm / {{ $payload['berat'] }} kg</td>
                                        </tr>
                                        <tr>
                                            <th>Riwayat Kesehatan</th>
                                            <td class="text-danger">{{ $payload['riwayatKesehatan'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Frekuensi Olahraga</th>
                                            <td>{{ $payload['frekuensiOlahraga'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pengalaman Gym</th>
                                            <td>{{ $payload['pengalaman'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Pola Makan</th>
                                            <td>{{ $payload['polaMakan'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Target Utama</th>
                                            <td>{{ $payload['targetUtama'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Keluhan</th>
                                            <td>{{ $payload['keluhan'] }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Recommendation (Read Only for Admin) --}}
                    @if(isset($result['details']))
                        <div class="card border-primary mb-3 mt-4" style="border-width: 2px;">
                            <div class="card-header bg-primary text-white text-center py-2">
                                <h4 class="fw-bold mb-0 text-white">Rekomendasi: {{ $result['details']['name'] }}</h4>
                            </div>
                            <div class="card-body p-3 text-start">
                                <div class="alert alert-light border">
                                    {!! $result['pesan'] !!}
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6 text-end border-end">
                                        <strong>Harga:</strong><br>
                                        <span class="text-primary fw-bold">{{ $result['details']['price'] }}</span>
                                    </div>
                                    <div class="col-6 text-start">
                                        <strong>Frekuensi:</strong><br>
                                        {{ $result['details']['freq'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>