<x-app-layout>
    <x-slot name="header">Dashboard Klien</x-slot>

    @php
        $status = $payment ? $payment->status : 'new';
        $isPremium = Auth::user()->is_premium;
    @endphp

    <div class="row">
        {{-- ==================================================================================
        STATE 1: ACTIVE (PREMIUM MEMBER)
        ================================================================================== --}}
        @if($isPremium)
            <div class="col-md-12">
                <div class="alert alert-success">
                    <h4 class="alert-heading">Selamat Datang, Premium Member!</h4>
                    <p>Paket Anda aktif sampai: <b>{{ Auth::user()->premium_until?->format('d M Y') }}</b></p>
                </div>

                {{-- AREA LAYANAN (Sesuai Requirement) --}}
                <div class="row mt-4">
                    {{-- NEXT SESSION WIDGET --}}
                    <div class="col-md-6">
                        <div class="card card-stats card-round {{ $nextSession ? 'bg-primary text-white' : '' }}">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-icon">
                                        <div
                                            class="icon-big text-center {{ $nextSession ? 'icon-white' : 'icon-primary' }} bubble-shadow-small">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                    <div class="col col-stats ms-3 ms-sm-0">
                                        <div class="numbers">
                                            <p class="card-category {{ $nextSession ? 'text-white' : '' }}">Sesi Berikutnya
                                            </p>
                                            @if($nextSession)
                                                <h4 class="card-title">{{ $nextSession->title }}</h4>
                                                <small>{{ $nextSession->date->format('l, d M Y - H:i') }}</small>
                                            @else
                                                <h4 class="card-title">Belum ada jadwal</h4>
                                                <small>Tunggu coach mengatur jadwal Anda</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ACTIONS --}}
                    <div class="col-md-3">
                        <a href="{{ route('client.sessions.index') }}" class="card text-decoration-none text-dark">
                            <div class="card-body text-center">
                                <i class="fas fa-list-alt fa-2x text-primary mb-2"></i>
                                <h5>Lihat Semua Sesi</h5>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('client.progress.index') }}" class="card text-decoration-none text-dark">
                            <div class="card-body text-center">
                                <i class="fas fa-chart-line fa-2x text-info mb-2"></i>
                                <h5>Progress Saya</h5>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            {{-- ==================================================================================
            STATE 2: REJECTED (Ditolak)
            ================================================================================== --}}
        @elseif($status == 'rejected')
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <h4 class="alert-heading">Pendaftaran Ditolak</h4>
                    <p>Mohon maaf, pendaftaran Anda ditolak oleh admin.</p>
                    <hr>
                    <p class="mb-0">Silakan hubungi admin atau lakukan pendaftaran ulang.</p>
                </div>
                {{-- Form Pendaftaran Ulang (bisa dicopy dari bawah, atau redirect) --}}
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Ulang?</h5>
                        <p>Silakan isi formulir pendaftaran di bawah ini kembali.</p>
                        {{-- Kita tampilkan form pendaftaran normal --}}
                        @include('client.partials.registration-form', ['packages' => $packages, 'user' => Auth::user()])
                    </div>
                </div>
            </div>

            {{-- ==================================================================================
            STATE 3: PENDING (Menunggu Verifikasi)
            ================================================================================== --}}
        @elseif($status == 'pending')
            <div class="col-md-8 offset-md-2">
                <div class="card card-warning card-announcment card-round">
                    <div class="card-body text-center">
                        <div class="card-opening">Menunggu Verifikasi</div>
                        <div class="card-desc">
                            Terima kasih telah mendaftar! Admin kami sedang memverifikasi bukti pembayaran Anda.
                            <br>Proses ini maksimal memakan waktu 1x24 Jam.
                        </div>
                    </div>
                </div>
            </div>

            {{-- ==================================================================================
            STATE 4: REVISION (Revisi) OR NEW (Belum Daftar)
            ================================================================================== --}}
        @else
            <div class="col-md-12">
                @if($status == 'revision')
                    <div class="alert alert-warning">
                        <b>PERHATIAN: Pendaftaran Perlu Revisi!</b><br>
                        Catatan Admin: "{{ $payment->admin_note }}"
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Formulir Pendaftaran Member</div>
                    </div>
                    <div class="card-body">
                        @include('client.partials.registration-form', ['packages' => $packages, 'user' => Auth::user(), 'payment' => $payment ?? null])
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>