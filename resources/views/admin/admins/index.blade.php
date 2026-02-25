<x-app-layout>
    <x-slot name="header">Manajemen Admin</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Daftar Admin Sistem</div>
                    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary btn-round ms-auto">
                        <i class="fa fa-plus"></i> Tambah Admin Baru
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($admins as $admin)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><b>{{ $admin->name }}</b>
                                            @if(auth()->id() === $admin->id)
                                                <span class="badge badge-info ms-2">Anda</span>
                                            @endif
                                        </td>
                                        <td>{{ $admin->email }}</td>
                                        <td>
                                            @if(auth()->id() !== $admin->id)
                                                <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada data admin lain.</td>
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