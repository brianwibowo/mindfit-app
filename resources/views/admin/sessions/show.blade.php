<x-app-layout>
    <div class="page-header">
        <h4 class="page-title">Detail Sesi</h4>
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
                <a href="{{ route('admin.sessions.index') }}">Monitoring Sesi</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Detail</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Informasi Sesi</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="fw-bold">Judul Sesi</h5>
                            <p>{{ $session->title }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold">Tipe Sesi</h5>
                            <span class="badge badge-{{ $session->type == 'online' ? 'info' : 'warning' }}">
                                {{ strtoupper($session->type) }}
                            </span>
                        </div>
                        <div class="col-md-6 mt-3">
                            <h5 class="fw-bold">Coach / Nutritionist</h5>
                            <p>{{ $session->coach->name ?? '-' }}
                                ({{ ucfirst($session->coach->specialization ?? '-') }})</p>
                        </div>
                        <div class="col-md-6 mt-3">
                            <h5 class="fw-bold">Klien</h5>
                            <p>{{ $session->client->name ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mt-3">
                            <h5 class="fw-bold">Waktu</h5>
                            <p>{{ $session->date->translatedFormat('l, d F Y') }} <br> Jam:
                                {{ $session->date->format('H:i') }}</p>
                        </div>
                        <div class="col-md-6 mt-3">
                            <h5 class="fw-bold">Status</h5>
                            <span
                                class="badge badge-{{ $session->status == 'scheduled' ? 'primary' : ($session->status == 'completed' ? 'success' : 'danger') }}">
                                {{ strtoupper($session->status) }}
                            </span>
                        </div>
                        <div class="col-md-12 mt-3">
                            <h5 class="fw-bold">Catatan / Link Meeting</h5>
                            <p>{{ $session->notes ?: 'Tidak ada catatan.' }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <button type="button" class="btn btn-primary" id="edit-btn">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    
                    <form action="{{ route('admin.sessions.destroy', $session->id) }}" 
                          method="POST" 
                          id="delete-form-{{ $session->id }}" 
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" id="delete-btn">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                    </form>
                    
                    <a href="{{ route('admin.sessions.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                // SweetAlert confirmation for Edit
                $('#edit-btn').click(function (e) {
                    e.preventDefault();
                    
                    swal({
                        title: 'Apakah Anda yakin?',
                        text: "Anda akan mengubah data sesi ini!",
                        icon: 'warning',
                        buttons: {
                            cancel: {
                                visible: true,
                                text: 'Batal',
                                className: 'btn btn-danger'
                            },
                            confirm: {
                                text: 'Ya, Edit!',
                                className: 'btn btn-success'
                            }
                        }
                    }).then((willEdit) => {
                        if (willEdit) {
                            window.location.href = "{{ route('admin.sessions.edit', $session->id) }}";
                        } else {
                            swal.close();
                        }
                    });
                });

                // SweetAlert confirmation for Delete
                $('#delete-btn').click(function (e) {
                    e.preventDefault();
                    
                    swal({
                        title: 'Apakah Anda yakin?',
                        text: "Data sesi ini akan dihapus permanen!",
                        icon: 'warning',
                        buttons: {
                            cancel: {
                                visible: true,
                                text: 'Batal',
                                className: 'btn btn-secondary'
                            },
                            confirm: {
                                text: 'Ya, Hapus!',
                                className: 'btn btn-danger'
                            }
                        },
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            $('#delete-form-{{ $session->id }}').submit();
                        } else {
                            swal.close();
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>