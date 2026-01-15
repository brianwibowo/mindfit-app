<x-app-layout>
    <x-slot name="header">Atur Coach: {{ $coach->name }}</x-slot>

    <div class="row">
        <div class="col-md-4">
            {{-- INFO COACH --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Profil Coach</div>
                    {{-- DELETE BUTTON --}}
                    <form id="delete-coach-{{ $coach->id }}" action="{{ route('admin.coaches.destroy', $coach->id) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm"
                            onclick="confirmDelete(event, 'delete-coach-{{ $coach->id }}')">
                            <i class="fa fa-trash"></i> Hapus Akun
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th>Nama</th>
                                <td>{{ $coach->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $coach->email }}</td>
                            </tr>
                            <tr>
                                <th>Spesialisasi</th>
                                <td>
                                    <span
                                        class="badge badge-{{ $coach->specialization == 'fitness' ? 'primary' : 'success' }}">
                                        {{ $coach->specialization == 'fitness' ? 'Fitness Coach' : ($coach->specialization == 'nutritionist' ? 'Nutritionist' : '-') }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Klien</th>
                                <td>{{ $assignedClients->count() }} orang</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ASSIGN CLIENT FORM --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Tambah Klien</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.coaches.assign_clients', $coach->id) }}" method="POST">
                        @csrf
                        <div class="form-group p-0">
                            <label>Pilih Klien (Searchable)</label>
                            <select name="client_ids[]" class="form-control select2" multiple="multiple"
                                style="width: 100%" required>
                                @forelse($availableClients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->email }})</option>
                                @empty
                                    <!-- No Clients -->
                                @endforelse
                            </select>
                            @if($availableClients->isEmpty())
                                <small class="text-danger mt-2">Tidak ada klien aktif yang tersedia/belum memiliki
                                    coach.</small>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-3" {{ $availableClients->isEmpty() ? 'disabled' : '' }}>
                            Simpan Klien
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            {{-- ASSIGNED CLIENTS TABLE --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Daftar Klien Diampu</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Klien</th>
                                    <th>Email</th>
                                    <th>Sejak</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assignedClients as $client)
                                    <tr>
                                        <td><b>{{ $client->name }}</b></td>
                                        <td>{{ $client->email }}</td>
                                        <td>{{ $client->pivot->created_at ? $client->pivot->created_at->format('d M Y') : '-' }}
                                        </td>
                                        <td>
                                            <form id="delete-form-{{ $client->id }}"
                                                action="{{ route('admin.coaches.unassign_client', ['coach' => $coach->id, 'client' => $client->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete(event, 'delete-form-{{ $client->id }}')">
                                                    <i class="fa fa-trash"></i> Lepas
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada klien di-assign ke coach ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.select2').select2({
                    placeholder: "Pilih Klien...",
                    allowClear: true
                });
            });
        </script>
    @endpush
</x-app-layout>