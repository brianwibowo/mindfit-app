<x-app-layout>
    <x-slot name="header">Manajemen Admin</x-slot>

    <!-- Custom CSS for Premium Design Elements -->
    <style>
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }
        .table thead th {
            font-size: 0.72rem !important;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            font-weight: 700;
            color: #8d94a5;
            border-bottom-width: 1px !important;
            background-color: rgba(0, 0, 0, 0.01) !important;
            padding: 14px 16px !important;
        }
        .table tbody td {
            padding: 14px 16px !important;
            vertical-align: middle;
        }
        .hover-shadow {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .hover-shadow:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.05) !important;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 14px; overflow: hidden;">
                <div class="card-header pb-3 bg-white" style="border-bottom: 1px solid rgba(0,0,0,0.05); padding: 20px 24px;">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                        <div>
                            <h4 class="card-title mb-1 fw-bold text-dark" style="font-size: 1.15rem;">Daftar Admin Sistem</h4>
                            <p class="text-muted text-xs mb-0">Kelola akun administrator dengan otoritas penuh pada sistem MindFit.</p>
                        </div>
                        <div>
                            <!-- Trigger Button for Wide Modal -->
                            <button type="button" class="btn btn-primary btn-round btn-sm px-3.5 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                                <i class="fa fa-plus me-1.5"></i> Tambah Admin Baru
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th class="text-end" style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($admins as $admin)
                                    <tr>
                                        <td>
                                            <span class="text-secondary fw-semibold" style="font-size: 0.85rem;">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $admin->name }}</span>
                                            @if(auth()->id() === $admin->id)
                                                <span class="badge ms-2" style="background-color: rgba(92, 85, 227, 0.1); color: #5c55e3; font-weight: 600; font-size: 0.65rem; border-radius: 30px; padding: 3px 8px;">
                                                    Anda
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-secondary" style="font-size: 0.85rem;">{{ $admin->email }}</span>
                                        </td>
                                        <td class="text-end">
                                            @if(auth()->id() !== $admin->id)
                                                <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini secara permanen?');" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-xs px-3 py-1.5 fw-semibold" style="border-radius: 30px; transition: all 0.2s;">
                                                        <i class="fa fa-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted text-xs italic px-3" style="font-style: italic;">Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="fas fa-user-shield fa-2x mb-2 opacity-50"></i><br>
                                            Belum ada data admin lain.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- WIDE MODAL POPUP (modal-lg) FOR ADDING NEW ADMIN -->
    <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 14px; overflow: hidden;">
                <div class="modal-header text-white" style="background: #5c55e3; padding: 16px 24px; border: none;">
                    <h5 class="modal-title fw-bold" id="addAdminModalLabel">
                        <i class="fas fa-user-plus me-2"></i> Tambah Administrator Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form action="{{ route('admin.admins.store') }}" method="POST" id="createAdminForm">
                    @csrf
                    <div class="modal-body p-4">
                        <p class="text-muted text-xs mb-4">
                            Isi formulir di bawah ini untuk mendaftarkan akun admin baru. Akun baru akan langsung aktif dan memiliki hak akses penuh ke sistem.
                        </p>

                        <!-- Row 1: Name and Email (Side-by-side) -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6 form-group">
                                <label for="name" class="form-label fw-bold text-dark" style="font-size: 0.8rem;">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="email" class="form-label fw-bold text-dark" style="font-size: 0.8rem;">Alamat Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email') }}" placeholder="Contoh: admin@mindfit.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2: Password and Confirm Password (Side-by-side) -->
                        <div class="row g-3">
                            <div class="col-md-6 form-group">
                                <label for="password" class="form-label fw-bold text-dark" style="font-size: 0.8rem;">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Minimal 8 karakter" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="password_confirmation" class="form-label fw-bold text-dark" style="font-size: 0.8rem;">Konfirmasi Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Ulangi password" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer bg-light p-3" style="border: none;">
                        <button type="button" class="btn btn-secondary btn-sm px-3.5 py-2 fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm px-4 py-2 fw-bold" style="border-radius: 8px; background: #5c55e3; border: none; box-shadow: 0 4px 10px rgba(92, 85, 227, 0.2);">
                            Simpan Admin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script to automatically open the modal if validation fails -->
    @if($errors->any())
        @push('scripts')
        <script>
            $(document).ready(function() {
                var myModal = new bootstrap.Modal(document.getElementById('addAdminModal'));
                myModal.show();
            });
        </script>
        @endpush
    @endif
</x-app-layout>