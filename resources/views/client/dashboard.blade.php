<x-app-layout>
    <x-slot name="header">Dashboard Klien</x-slot>

    {{-- ACTION BUTTON --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <a href="{{ route('client.payment.create') }}" class="btn btn-primary btn-lg w-100">
                <i class="fas fa-plus-circle"></i> Daftar Paket Baru / Perpanjang Langganan
            </a>
        </div>
    </div>

    {{-- HISTORY TABLE --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Riwayat & Status Langganan</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Paket</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Periode Paket</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $p)
                                    <tr>
                                        <td>{{ $p->created_at->format('d M Y') }}</td>
                                        <td>
                                            <b>{{ $p->package_data['package_name'] ?? '-' }}</b><br>
                                            <small>{{ $p->package_data['package_duration'] ?? 0 }} Hari</small>
                                        </td>
                                        <td>Rp {{ number_format($p->package_data['total_price'] ?? 0, 0, ',', '.') }}</td>
                                        <td>
                                            @if($p->status == 'approved')
                                                <span class="badge badge-success">Active</span>
                                            @elseif($p->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($p->status == 'revision')
                                                <span class="badge badge-warning">Revisi</span>
                                            @elseif($p->status == 'rejected')
                                                <span class="badge badge-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->status == 'approved' && $p->subscription_end)
                                                {{ \Carbon\Carbon::parse($p->subscription_end)->format('d M Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('client.payment.show', $p->id) }}" class="btn btn-primary btn-sm btn-round">
                                                Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada riwayat langganan.</td>
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