<x-app-layout>
    <x-slot name="header">Jadwal Coaching Saya</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Riwayat & Jadwal Sesi</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal & Jam</th>
                                    <th>Judul Sesi</th>
                                    <th>Coach</th>
                                    <th>Tipe</th>
                                    <th>Catatan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sessions as $session)
                                    <tr class="{{ $session->date->isPast() ? 'text-muted' : '' }}">
                                        <td style="white-space: nowrap;">
                                            {{ $session->date->format('d M Y') }} <br>
                                            <small>{{ $session->date->format('H:i') }} WIB</small>
                                        </td>
                                        <td>
                                            <b>{{ $session->title }}</b>
                                        </td>
                                        <td>{{ $session->coach->name }}</td>
                                        <td>
                                            <span class="badge badge-{{ $session->type == 'online' ? 'info' : 'primary' }}">
                                                {{ ucfirst($session->type) }}
                                            </span>
                                        </td>
                                        <td>{{ Str::limit($session->notes, 50) }}</td>
                                        <td>
                                            @if($session->date->isPast())
                                                <span class="badge badge-secondary">Selesai</span>
                                            @else
                                                <span class="badge badge-success">Akan Datang</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada jadwal sesi.</td>
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