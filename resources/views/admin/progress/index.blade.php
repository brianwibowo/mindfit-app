<x-app-layout>
    <div class="page-header">
        <h4 class="page-title">Monitoring Progress Klien</h4>
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
                <a href="#">Monitoring Progress</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Log Aktivitas Progress</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Klien</th>
                                    <th>Tipe Log</th>
                                    <th>Feedback Coach</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td>{{ $log->date->translatedFormat('d F Y') }}</td>
                                        <td>{{ $log->client->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $log->type == 'weight' ? 'primary' : 'info' }}">
                                                {{ ucfirst($log->type) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($log->coach_note)
                                                <span class="badge badge-success">Sudah Direview</span>
                                            @else
                                                <span class="badge badge-warning">Belum Direview</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.progress.show', $log->id) }}"
                                                class="btn btn-primary btn-sm btn-round">
                                                <i class="fa fa-eye"></i> Lihat Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada data progress.</td>
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