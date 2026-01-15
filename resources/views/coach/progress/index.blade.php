<x-app-layout>
    <x-slot name="header">Monitoring Progress Klien</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Log Progress Terbaru</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Klien</th>
                                    <th>Tipe Log</th>
                                    <th>Ringkasan</th>
                                    <th>Status Feedback</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td>{{ $log->date->format('d M Y') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-xs me-2">
                                                    <span
                                                        class="avatar-title rounded-circle border border-white bg-primary">{{ substr($log->client->name, 0, 1) }}</span>
                                                </div>
                                                {{ $log->client->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ ucfirst($log->type) }}</span>
                                        </td>
                                        <td>
                                            @if($log->weight) <small>BB: {{ $log->weight }}kg</small><br> @endif
                                            @if($log->waist) <small>Pinggang: {{ $log->waist }}cm</small> @endif
                                            @if(!$log->waist && !$log->weight) - @endif
                                        </td>
                                        <td>
                                            @if($log->coach_note)
                                                <span class="badge badge-success"><i class="fas fa-check"></i> Sudah
                                                    review</span>
                                            @else
                                                <span class="badge badge-warning">Belum di-review</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('coach.progress.show', $log->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada log progress dari klien Anda.</td>
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