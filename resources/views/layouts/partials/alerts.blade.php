@push('scripts')
    {{-- Use Local SweetAlert from KaiAdmin Plugins --}}
    <script src="{{ asset('kaiadmin/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
    
    @if (session('success'))
    <script>
        $(document).ready(function() {
            swal({
                title: "Berhasil!",
                text: "{{ session('success') }}",
                icon: "success",
                buttons: {
                    confirm: {
                        text: "OK",
                        value: true,
                        visible: true,
                        className: "btn btn-primary",
                        closeModal: true
                    }
                }
            });
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        $(document).ready(function() {
            swal({
                title: "Error!",
                text: "{{ session('error') }}",
                icon: "error",
                buttons: {
                    confirm: {
                        text: "Tutup",
                        className: "btn btn-danger",
                    }
                }
            });
        });
    </script>
    @endif

    <script>
        // Global Delete Confirmation
        function confirmDelete(event, formId) {
            event.preventDefault();
            swal({
                title: 'Apakah Anda Yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                buttons: {
                    cancel: {
                        visible: true,
                        text: 'Batal',
                        className: 'btn btn-danger'
                    },
                    confirm: {
                        text: 'Ya, Hapus!',
                        className: 'btn btn-success'
                    }
                }
            }).then((willDelete) => {
                if (willDelete) {
                    document.getElementById(formId).submit();
                } else {
                    swal.close();
                }
            });
        }
    </script>
@endpush

{{-- Validation Errors (Bootstrap style) --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi Kesalahan!</strong>
        <ul class="mb-0 pl-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif