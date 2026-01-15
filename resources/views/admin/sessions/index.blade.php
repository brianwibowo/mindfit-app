<x-app-layout>
    <div class="page-header">
        <h4 class="page-title">Monitoring Sesi</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Monitoring Sesi</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Daftar Semua Sesi</h4>
                        <a href="{{ route('admin.sessions.create') }}" class="btn btn-primary btn-round ms-auto">
                            <i class="fa fa-plus"></i>
                            Buat Sesi
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="add-row" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Sesi</th>
                                    <th>Coach</th>
                                    <th>Klien</th>
                                    <th>Status</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sessions as $session)
                                    <tr>
                                        <td>{{ $session->date->translatedFormat('d F Y') }}</td>
                                        <td>{{ $session->date->format('H:i') }}</td>
                                        <td>{{ $session->title }} <br> <small
                                                class="text-muted">{{ ucfirst($session->type) }}</small></td>
                                        <td>{{ $session->coach->name ?? '-' }}</td>
                                        <td>{{ $session->client->name ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $session->status == 'scheduled' ? 'primary' : ($session->status == 'completed' ? 'success' : 'danger') }}">
                                                {{ ucfirst($session->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{ route('admin.sessions.show', $session->id) }}"
                                                    class="btn btn-primary btn-sm btn-round" data-bs-toggle="tooltip"
                                                    title="Lihat Detail">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada sesi yang dijadwalkan</td>
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