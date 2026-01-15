<x-app-layout>
    <x-slot name="header">Dashboard Coach {{ ucfirst(Auth::user()->specialization) }}</x-slot>

    <div class="row">
        {{-- Stats Cards --}}
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Klien Aktif</p>
                                <h4 class="card-title">{{ $clients->count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Daftar Klien Saya</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Klien</th>
                                    <th>Email & Kontak</th>
                                    <th>Tipe Bimbingan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clients as $index => $client)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-2">
                                                    <span
                                                        class="avatar-title rounded-circle border border-white bg-secondary">{{ substr($client->name, 0, 1) }}</span>
                                                </div>
                                                <b>{{ $client->name }}</b>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $client->email }}<br>
                                            <small class="text-muted">{{ $client->phone ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ ucfirst($client->pivot->type) }}</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown">
                                                    Opsi
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('coach.sessions.create', $client->id) }}">
                                                            <i class="fas fa-calendar-plus me-2"></i> Jadwalkan Sesi
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('coach.progress.index') }}">
                                                            <i class="fas fa-chart-line me-2"></i> Lihat Progress All
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fab fa-whatsapp me-2"></i> Chat WhatsApp
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada klien yang di-assign ke Anda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>