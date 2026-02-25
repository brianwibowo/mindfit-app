<x-app-layout>
    <div class="page-header">
        <h4 class="page-title">Detail Jadwal Sesi</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('client.dashboard') }}">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a
                    href="{{ route('client.sessions.index', ['type' => $session->type == 'online' ? 'coach' : 'nutritionist']) }}">Jadwal
                    Sesi</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Detail Sesi</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Informasi Sesi Coaching</div>
                    @if($session->date->isPast())
                        <span class="badge badge-secondary">Selesai</span>
                    @else
                        <span class="badge badge-success">Akan Datang</span>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table table-typo">
                        <tbody>
                            <tr>
                                <td style="width: 30%"><strong>Judul Sesi</strong></td>
                                <td>: {{ $session->title }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal & Waktu</strong></td>
                                <td>: {{ $session->date->format('d F Y') }} <br> : {{ $session->date->format('H:i') }}
                                    WIB</td>
                            </tr>
                            <tr>
                                <td><strong>Tipe Sesi</strong></td>
                                <td>:
                                    <span class="badge badge-{{ $session->type == 'online' ? 'info' : 'primary' }}">
                                        {{ ucfirst($session->type) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Coach / Pelatih</strong></td>
                                <td>: {{ $session->coach->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Catatan / Pesan</strong></td>
                                <td>: {{ $session->notes ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="alert alert-info mt-4" role="alert">
                        <strong>Hubungi Coach:</strong> Jika ada pertanyaan lebih lanjut terkait sesi ini, Anda dapat
                        menghubungi Coach secara langsung.
                    </div>

                    <div class="d-flex justify-content-center mt-4 mb-2">
                        @if($session->coach->phone)
                            @php
                                // Clean phone number to format 62xxx
                                $phone = preg_replace('/[^0-9]/', '', $session->coach->phone);
                                if (str_starts_with($phone, '0')) {
                                    $phone = '62' . substr($phone, 1);
                                }
                                $waText = urlencode("Halo Coach {$session->coach->name}, saya ingin berdiskusi mengenai sesi '{$session->title}' pada tanggal {$session->date->format('d M Y')}.");
                            @endphp
                            <a href="https://wa.me/{{ $phone }}?text={{ $waText }}" target="_blank"
                                class="btn btn-success btn-lg btn-round">
                                <i class="fab fa-whatsapp"></i> Hubungi Coach via WA
                            </a>
                        @else
                            <button class="btn btn-secondary btn-lg btn-round" disabled>
                                <i class="fab fa-whatsapp"></i> Nomor WA Coach Belum Terdaftar
                            </button>
                        @endif
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ url()->previous() }}" class="btn btn-primary btn-border">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>