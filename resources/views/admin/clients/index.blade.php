<x-app-layout>
    <x-slot name="header">Manajemen Pendaftaran Klien</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Daftar Pendaftaran</div>
                    <div class="card-category">Kelola pendaftaran masuk berdasarkan status.</div>
                </div>
                <div class="card-body">
                    {{-- TABS --}}
                    <ul class="nav nav-pills nav-secondary mb-3">
                        <li class="nav-item">
                            <a class="nav-link {{ $status == 'pending' ? 'active' : '' }}"
                                href="{{ route('admin.clients.index', ['status' => 'pending']) }}">Baru (Pending)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status == 'approved' ? 'active' : '' }}"
                                href="{{ route('admin.clients.index', ['status' => 'approved']) }}">Diterima
                                (Active)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status == 'revision' ? 'active' : '' }}"
                                href="{{ route('admin.clients.index', ['status' => 'revision']) }}">Revisi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status == 'rejected' ? 'active' : '' }}"
                                href="{{ route('admin.clients.index', ['status' => 'rejected']) }}">Ditolak</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status == 'all' ? 'active' : '' }}"
                                href="{{ route('admin.clients.index', ['status' => 'all']) }}">Semua</a>
                        </li>
                    </ul>

                    {{-- TABLE --}}
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tgl Daftar</th>
                                    <th>Klien</th>
                                    <th>Paket</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $p)
                                    <tr>
                                        <td>
                                            {{ $p->created_at->format('d M Y') }}<br>
                                            <small class="text-muted">{{ $p->created_at->format('H:i') }} WIB</small>
                                        </td>
                                        <td>
                                            <b>{{ $p->user->name }}</b><br>
                                            <small>{{ $p->user->email }}</small>
                                        </td>
                                        <td>{{ $p->package_data['package_name'] ?? '-' }}</td>
                                        <td>Rp {{ number_format($p->package_data['total_price'] ?? 0, 0, ',', '.') }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $p->status == 'approved' ? 'success' : ($p->status == 'pending' ? 'warning' : ($p->status == 'rejected' ? 'danger' : 'info')) }}">
                                                {{ ucfirst($p->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.verification.show', $p->id) }}"
                                                class="btn btn-primary btn-sm">
                                                Verifikasi
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data pendaftaran dengan status ini.
                                        </td>
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