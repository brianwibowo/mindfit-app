<x-app-layout>
    <x-slot name="header">Manajemen Coach & Nutritionist</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Daftar Coach</div>
                    <a href="{{ route('admin.coaches.create') }}" class="btn btn-primary btn-round ms-auto">
                        <i class="fa fa-plus"></i> Tambah Coach Baru
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
                                    <th>Spesialisasi</th>
                                    <th>Klien Diampu</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coaches as $coach)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><b>{{ $coach->name }}</b></td>
                                        <td>{{ $coach->email }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $coach->specialization == 'fitness' ? 'primary' : 'success' }}">
                                                {{ ucfirst($coach->specialization ?? 'General') }}
                                            </span>
                                        </td>
                                        <td>{{ $coach->clients()->count() }} Klien</td>
                                        <td><span class="badge badge-success">Active</span></td>
                                        <td>
                                            <a href="{{ route('admin.coaches.show', $coach->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fa fa-cogs"></i> Atur Coach
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada data coach.</td>
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