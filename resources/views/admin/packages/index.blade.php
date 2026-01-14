<x-app-layout>
    <x-slot name="header">Manajemen Paket</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Daftar Paket</div>
                    <a href="{{ route('admin.packages.create') }}" class="btn btn-primary btn-round">
                        <i class="fa fa-plus"></i> Buat Paket Baru
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Cvr</th>
                                    <th>Nama Paket</th>
                                    <th>Tipe</th>
                                    <th>Harga</th>
                                    <th>Durasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($packages as $package)
                                    <tr>
                                        <td>
                                            @if($package->image)
                                                <img src="{{ asset('storage/' . $package->image) }}" alt="img" width="50"
                                                    class="rounded">
                                            @else
                                                <span class="text-muted">No Img</span>
                                            @endif
                                        </td>
                                        <td>{{ $package->name }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $package->type == 'fitness' ? 'primary' : 'warning' }}">
                                                {{ ucfirst($package->type) }}
                                            </span>
                                        </td>
                                        <td>Rp {{ number_format($package->price, 0, ',', '.') }}</td>
                                        <td>{{ $package->duration_days }} Hari</td>
                                        <td>
                                            <span class="badge badge-{{ $package->is_active ? 'success' : 'danger' }}">
                                                {{ $package->is_active ? 'Aktif' : 'Non-Aktif' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.packages.show', $package->id) }}"
                                                class="btn btn-sm btn-info">Lihat</a>
                                            <a href="{{ route('admin.packages.edit', $package->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Hapus paket ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada paket tersedia.</td>
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