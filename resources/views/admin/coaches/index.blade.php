<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">

<x-app-layout>
    <x-slot name="header">Manajemen Coach & Nutritionist</x-slot>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="page-title text-dark">Daftar Coach & Nutritionist</h4>
        <button type="button" class="btn btn-primary btn-round" data-bs-toggle="modal" data-bs-target="#createCoachModal" id="btnCreateCoach">
            <i class="fa fa-plus"></i> Tambah Coach Baru
        </button>
    </div>

    <!-- Skeletons Template (hidden helper) -->
    <template id="skeletons-template">
        @for($i = 0; $i < 8; $i++)
            <div class="col skeleton-card">
                <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 14px;">
                    <div class="skeleton-shimmer" style="height: 170px; background: rgba(0,0,0,0.08);"></div>
                    <div class="card-body text-center d-flex flex-column align-items-center py-3">
                        <div class="skeleton-shimmer mb-1" style="width: 65%; height: 18px; background: rgba(0,0,0,0.06); border-radius: 4px;"></div>
                        <div class="skeleton-shimmer mb-3" style="width: 75%; height: 12px; background: rgba(0,0,0,0.05); border-radius: 4px;"></div>
                        <div class="w-100 d-flex justify-content-around py-2 border-top mt-auto">
                            <div class="skeleton-shimmer" style="width: 35%; height: 12px; background: rgba(0,0,0,0.05); border-radius: 4px;"></div>
                            <div class="skeleton-shimmer" style="width: 35%; height: 12px; background: rgba(0,0,0,0.05); border-radius: 4px;"></div>
                        </div>
                    </div>
                    <div class="card-footer border-0 d-flex p-2 px-3 pb-3 gap-2" style="background: transparent;">
                        <div class="skeleton-shimmer flex-grow-1" style="height: 30px; background: rgba(0,0,0,0.06); border-radius: 8px;"></div>
                        <div class="skeleton-shimmer flex-grow-1" style="height: 30px; background: rgba(0,0,0,0.06); border-radius: 8px;"></div>
                    </div>
                </div>
            </div>
        @endfor
    </template>

    <!-- Grid Container for AJax loaded cards -->
    <div id="coaches-container" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
        <!-- Initially rendered skeletons while AJAX load triggers -->
        @for($i = 0; $i < 8; $i++)
            <div class="col skeleton-card">
                <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 14px;">
                    <div class="skeleton-shimmer" style="height: 170px; background: rgba(0,0,0,0.08);"></div>
                    <div class="card-body text-center d-flex flex-column align-items-center py-3">
                        <div class="skeleton-shimmer mb-1" style="width: 65%; height: 18px; background: rgba(0,0,0,0.06); border-radius: 4px;"></div>
                        <div class="skeleton-shimmer mb-3" style="width: 75%; height: 12px; background: rgba(0,0,0,0.05); border-radius: 4px;"></div>
                        <div class="w-100 d-flex justify-content-around py-2 border-top mt-auto">
                            <div class="skeleton-shimmer" style="width: 35%; height: 12px; background: rgba(0,0,0,0.05); border-radius: 4px;"></div>
                            <div class="skeleton-shimmer" style="width: 35%; height: 12px; background: rgba(0,0,0,0.05); border-radius: 4px;"></div>
                        </div>
                    </div>
                    <div class="card-footer border-0 d-flex p-2 px-3 pb-3 gap-2" style="background: transparent;">
                        <div class="skeleton-shimmer flex-grow-1" style="height: 30px; background: rgba(0,0,0,0.06); border-radius: 8px;"></div>
                        <div class="skeleton-shimmer flex-grow-1" style="height: 30px; background: rgba(0,0,0,0.06); border-radius: 8px;"></div>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <!-- Edit Coach Modal -->
    <div class="modal fade" id="editCoachModal" tabindex="-1" role="dialog" aria-labelledby="editCoachModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow" style="border-radius: 12px;">
                <form id="editCoachForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="cropped_avatar" id="edit_cropped_avatar_data">
                    <div class="modal-header bg-warning text-white" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                        <h5 class="modal-title fw-bold" id="editCoachModalLabel">
                            <i class="fas fa-edit me-2"></i>Edit Data Coach
                        </h5>
                        <button type="button" style="background: none; border: none; font-size: 1.5rem; color: #fff; line-height: 1; opacity: 0.8; cursor: pointer;" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="max-height: calc(100vh - 210px); overflow-y: auto;">
                        <!-- Centered Photo Preview at the Very Top -->
                        <div class="text-center mb-4 p-3 bg-light rounded" style="border: 1px dashed rgba(0,0,0,0.08);">
                            <div id="edit_avatar_preview_container" class="rounded-circle overflow-hidden border mx-auto shadow-sm" style="width: 120px; height: 120px; display: none;">
                                <img id="edit_avatar_preview" src="" alt="preview" class="w-100 h-100 object-fit-cover">
                            </div>
                            <div id="edit_avatar_placeholder" class="rounded-circle bg-white border mx-auto shadow-sm" style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user text-muted fa-3x"></i>
                            </div>
                            <div class="mt-3 mx-auto" style="max-width: 320px;">
                                <label for="edit_avatar" class="form-label fw-bold d-block">Unggah Foto Profil (Avatar)</label>
                                <input type="file" class="form-control" id="edit_avatar" name="avatar" accept="image/*, .heic, .heif">
                                <small class="text-muted d-block mt-1">Format: jpeg, png, jpg, gif, heic, heif (Max 2MB). Biarkan kosong jika tidak diubah.</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="edit_name" class="form-label fw-bold">Nama Coach</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="edit_email" class="form-label fw-bold">Email Address</label>
                                <input type="email" class="form-control" id="edit_email" name="email" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="edit_phone" class="form-label fw-bold">Nomor WhatsApp</label>
                                <input type="text" class="form-control" id="edit_phone" name="phone" placeholder="Contoh: 08123456789" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="edit_specialization" class="form-label fw-bold">Spesialisasi</label>
                                <select name="specialization" id="edit_specialization" class="form-select" required>
                                    <option value="fitness">Fitness (Personal Trainer)</option>
                                    <option value="nutritionist">Nutritionist (Ahli Gizi)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="edit_expertise" class="form-label fw-bold">Keahlian / Spesialisasi</label>
                                <input type="text" class="form-control" id="edit_expertise" name="expertise" placeholder="Contoh: Fat Loss, Muscle Building, Diet Diabetes">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="edit_is_active" class="form-label fw-bold">Status Keaktifan</label>
                                <select name="is_active" id="edit_is_active" class="form-select" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Non-Aktif</option>
                                </select>
                            </div>
                        </div>


                        <div class="row mt-2 border-top pt-3">
                            <div class="col-md-6 form-group mb-3">
                                <label for="edit_password" class="form-label fw-bold text-warning">Password Baru (Opsional)</label>
                                <input type="password" class="form-control" id="edit_password" name="password" placeholder="Biarkan kosong jika tidak diubah">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="edit_password_confirmation" class="form-label fw-bold">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation" placeholder="Biarkan kosong jika tidak diubah">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light d-flex justify-content-between">
                        <button type="button" class="btn btn-danger" id="btnDeleteCoach">
                            <i class="fas fa-trash-alt me-1"></i>Hapus Coach
                        </button>
                        <div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Update Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Coach Modal -->
    <div class="modal fade" id="createCoachModal" tabindex="-1" role="dialog" aria-labelledby="createCoachModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow" style="border-radius: 12px;">
                <form id="createCoachForm" action="{{ route('admin.coaches.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="cropped_avatar" id="create_cropped_avatar_data">
                    <div class="modal-header bg-primary text-white" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                        <h5 class="modal-title fw-bold" id="createCoachModalLabel">
                            <i class="fas fa-plus me-2"></i>Tambah Coach Baru
                        </h5>
                        <button type="button" style="background: none; border: none; font-size: 1.5rem; color: #fff; line-height: 1; opacity: 0.8; cursor: pointer;" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="max-height: calc(100vh - 210px); overflow-y: auto;">
                        <!-- Centered Photo Preview at the Very Top -->
                        <div class="text-center mb-4 p-3 bg-light rounded" style="border: 1px dashed rgba(0,0,0,0.08);">
                            <div id="create_avatar_preview_container" class="rounded-circle overflow-hidden border mx-auto shadow-sm" style="width: 120px; height: 120px; display: none;">
                                <img id="create_avatar_preview" src="" alt="preview" class="w-100 h-100 object-fit-cover">
                            </div>
                            <div id="create_avatar_placeholder" class="rounded-circle bg-white border mx-auto shadow-sm" style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user text-muted fa-3x"></i>
                            </div>
                            <div class="mt-3 mx-auto" style="max-width: 320px;">
                                <label for="create_avatar" class="form-label fw-bold d-block">Unggah Foto Profil (Avatar)</label>
                                <input type="file" class="form-control" id="create_avatar" name="avatar" accept="image/*, .heic, .heif">
                                <small class="text-muted d-block mt-1">Format: jpeg, png, jpg, gif, heic, heif (Max 2MB).</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="create_name" class="form-label fw-bold">Nama Coach</label>
                                <input type="text" class="form-control" id="create_name" name="name" placeholder="Nama Lengkap & Gelar" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="create_email" class="form-label fw-bold">Email Address</label>
                                <input type="email" class="form-control" id="create_email" name="email" placeholder="email@domain.com" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="create_phone" class="form-label fw-bold">Nomor WhatsApp</label>
                                <input type="text" class="form-control" id="create_phone" name="phone" placeholder="Contoh: 08123456789" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="create_specialization" class="form-label fw-bold">Spesialisasi</label>
                                <select name="specialization" id="create_specialization" class="form-select" required>
                                    <option value="fitness">Fitness (Personal Trainer)</option>
                                    <option value="nutritionist">Nutritionist (Ahli Gizi)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="create_expertise" class="form-label fw-bold">Keahlian / Spesialisasi</label>
                                <input type="text" class="form-control" id="create_expertise" name="expertise" placeholder="Contoh: Fat Loss, Muscle Building, Diet Diabetes">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="create_is_active" class="form-label fw-bold">Status Keaktifan</label>
                                <select name="is_active" id="create_is_active" class="form-select" required>
                                    <option value="1">Aktif</option>
                                    <option value="0">Non-Aktif</option>
                                </select>
                            </div>
                        </div>


                        <div class="row mt-2 border-top pt-3">
                            <div class="col-md-6 form-group mb-3">
                                <label for="create_password" class="form-label fw-bold text-primary">Password</label>
                                <input type="password" class="form-control" id="create_password" name="password" placeholder="Masukkan password akun" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="create_password_confirmation" class="form-label fw-bold">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="create_password_confirmation" name="password_confirmation" placeholder="Ulangi password akun" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Coach</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Hidden Form for Delete Action -->
    <form id="deleteCoachForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- Crop Image Modal -->
    <div class="modal fade" id="cropImageModal" tabindex="-1" role="dialog" aria-labelledby="cropImageModalLabel" aria-hidden="true" style="z-index: 1060;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow" style="border-radius: 12px;">
                <div class="modal-header bg-primary text-white" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="modal-title fw-bold" id="cropImageModalLabel">Potong Gambar Profil</h5>
                    <button type="button" id="btnCancelCrop" aria-label="Close" style="background: none; border: none; font-size: 1.5rem; color: #fff; line-height: 1; opacity: 0.8; cursor: pointer;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center bg-light">
                    <div class="img-container mx-auto" style="max-height: 380px; max-width: 100%; overflow: hidden;">
                        <img id="cropperImageSource" src="" style="max-width: 100%; display: block; margin: 0 auto;">
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                    <button type="button" class="btn btn-secondary" id="btnCancelCropBtn">Batal</button>
                    <button type="button" class="btn btn-success" id="btnCropApply">Terapkan Potongan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS for Shimmer Animation and Layout -->
    <style>
        @keyframes pulse {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }
        .skeleton-shimmer {
            animation: pulse 1.5s infinite ease-in-out;
        }
        .coach-hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        }
        [data-theme="dark"] .coach-hover-card {
            background-color: var(--bg-card) !important;
            border: 1px solid var(--border-color) !important;
        }
        [data-theme="dark"] .modal-content {
            background-color: var(--bg-card) !important;
            color: #fff !important;
            border: 1px solid var(--border-color) !important;
        }
        [data-theme="dark"] .modal-header {
            border-bottom: 1px solid var(--border-color) !important;
        }
        [data-theme="dark"] .modal-footer {
            background-color: rgba(255,255,255,0.02) !important;
            border-top: 1px solid var(--border-color) !important;
        }
        [data-theme="dark"] .modal-body label {
            color: #fff !important;
        }
    </style>

    @push('scripts')
    <!-- Cropper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- AJAX Loading and Modal Logic Scripts -->
    <script>
        $(document).ready(function() {
            var isFormDirty = false;
            var cropper = null;
            var activeCropSource = null;

            // Track form edits in both forms
            $(document).on('input change', '#editCoachForm input, #editCoachForm select, #createCoachForm input, #createCoachForm select', function() {
                isFormDirty = true;
            });

            // Reset and open create modal
            $(document).on('click', '#btnCreateCoach', function() {
                $('#createCoachForm')[0].reset();
                $('#create_cropped_avatar_data').val('');
                $('#create_avatar_preview').attr('src', '');
                $('#create_avatar_preview_container').hide();
                $('#create_avatar_placeholder').show();
                isFormDirty = false;
            });

            // Prevent closing edit or create modal if changes were made
            $('#editCoachModal, #createCoachModal').on('hide.bs.modal', function(e) {
                var currentModal = $(this);
                if (isFormDirty) {
                    e.preventDefault(); // Stop closing modal
                    
                    Swal.fire({
                        title: "Perubahan Belum Disimpan!",
                        text: "Apakah Anda yakin ingin membatalkan perubahan dan menutup form ini?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Ya, Tutup",
                        cancelButtonText: "Tidak, Tetap Edit",
                        reverseButtons: true,
                        customClass: {
                            confirmButton: "btn btn-secondary mx-2",
                            cancelButton: "btn btn-danger mx-2"
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            isFormDirty = false; // Reset dirty flag
                            currentModal.modal('hide'); // Close modal programmatically
                        }
                    });
                }
            });

            // Function to load coaches via AJAX
            function loadCoaches(url) {
                // Show skeletons while loading
                $('#coaches-container').html($('#skeletons-template').html());

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(data) {
                        // Smoothly transition skeletons out and render content
                        setTimeout(function() {
                            $('#coaches-container').html(data);
                        }, 400);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading coaches:", error);
                        $('#coaches-container').html('<div class="col-12 text-center py-5"><p class="text-danger">Gagal memuat data coach. Silakan coba lagi.</p></div>');
                    }
                });
            }

            // Trigger initial AJAX load on document ready
            loadCoaches(window.location.href);

            // Handle dynamic pagination link clicks
            $(document).on('click', '#coaches-container .pagination a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                loadCoaches(url);
            });

            // Populate and open edit modal
            $(document).on('click', '.btn-edit-coach', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var email = $(this).data('email');
                var phone = $(this).data('phone');
                var specialization = $(this).data('specialization');
                var isActive = $(this).data('is-active');
                var avatarUrl = $(this).data('avatar-url');
                var expertise = $(this).data('expertise');

                // Populate form inputs
                $('#edit_name').val(name);
                $('#edit_email').val(email);
                $('#edit_phone').val(phone);
                $('#edit_specialization').val(specialization);
                $('#edit_is_active').val(isActive);
                $('#edit_expertise').val(expertise);
                $('#edit_password').val('');
                $('#edit_password_confirmation').val('');
                $('#edit_cropped_avatar_data').val(''); // Reset cropped image input
                $('#edit_avatar').val(''); // Reset file input

                // Set Action attributes
                $('#editCoachForm').attr('action', '/admin/coaches/' + id);
                $('#btnDeleteCoach').data('id', id);

                // Handle image avatar preview inside modal
                if (avatarUrl) {
                    $('#edit_avatar_preview').attr('src', avatarUrl);
                    $('#edit_avatar_preview_container').show();
                    $('#edit_avatar_placeholder').hide();
                } else {
                    $('#edit_avatar_preview').attr('src', '');
                    $('#edit_avatar_preview_container').hide();
                    $('#edit_avatar_placeholder').show();
                }

                // Reset dirty state since modal just loaded original database state
                isFormDirty = false;

                // Show modal window
                $('#editCoachModal').modal('show');
            });

            // Handle file input upload in Edit Modal (Init Cropper)
            $('#edit_avatar').on('change', function(e) {
                activeCropSource = 'edit';
                var files = e.target.files;
                if (files && files.length > 0) {
                    var file = files[0];
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#cropperImageSource').attr('src', e.target.result);
                        $('#cropImageModal').modal('show');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Handle file input upload in Create Modal (Init Cropper)
            $('#create_avatar').on('change', function(e) {
                activeCropSource = 'create';
                var files = e.target.files;
                if (files && files.length > 0) {
                    var file = files[0];
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#cropperImageSource').attr('src', e.target.result);
                        $('#cropImageModal').modal('show');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Initialize Cropper when Crop modal is shown
            $('#cropImageModal').on('shown.bs.modal', function() {
                var image = document.getElementById('cropperImageSource');
                cropper = new Cropper(image, {
                    aspectRatio: 1, // Circular avatar = 1:1 square
                    viewMode: 1,
                    autoCropArea: 1,
                });
            }).on('hidden.bs.modal', function() {
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
            });

            // Handle Crop Apply Button Click
            $('#btnCropApply').click(function() {
                if (cropper) {
                    var canvas = cropper.getCroppedCanvas({
                        width: 300,
                        height: 300
                    });
                    var dataURL = canvas.toDataURL('image/jpeg');

                    if (activeCropSource === 'edit') {
                        // Directly update the avatar preview at the top of the form
                        $('#edit_avatar_preview').attr('src', dataURL);
                        $('#edit_avatar_preview_container').show();
                        $('#edit_avatar_placeholder').hide();

                        // Put the base64 image data inside hidden input for direct store/update parsing
                        $('#edit_cropped_avatar_data').val(dataURL);
                    } else if (activeCropSource === 'create') {
                        // Directly update the avatar preview at the top of the form
                        $('#create_avatar_preview').attr('src', dataURL);
                        $('#create_avatar_preview_container').show();
                        $('#create_avatar_placeholder').hide();

                        // Put the base64 image data inside hidden input for direct store/update parsing
                        $('#create_cropped_avatar_data').val(dataURL);
                    }

                    // Close crop modal
                    $('#cropImageModal').modal('hide');

                    // Set form dirty flag since image changed
                    isFormDirty = true;
                }
            });

            // Cancel Crop Button handlers
            $('#btnCancelCrop, #btnCancelCropBtn').click(function() {
                if (activeCropSource === 'edit') {
                    $('#edit_avatar').val(''); // clear file input
                } else if (activeCropSource === 'create') {
                    $('#create_avatar').val(''); // clear file input
                }
                $('#cropImageModal').modal('hide');
            });

            // Handle delete action with strong warning confirmation dialog
            $('#btnDeleteCoach').click(function() {
                var coachId = $(this).data('id');
                var warningText = "PERINGATAN: Menghapus coach ini akan melepaskan hubungan dengan seluruh klien yang diampu. Tindakan ini tidak dapat dibatalkan!";
                
                Swal.fire({
                    title: "Apakah Anda Yakin?",
                    text: warningText,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal",
                    customClass: {
                        confirmButton: "btn btn-danger mx-2",
                        cancelButton: "btn btn-secondary mx-2"
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        isFormDirty = false; // Bypass closing warnings
                        var form = $('#deleteCoachForm');
                        form.attr('action', '/admin/coaches/' + coachId);
                        form.submit();
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>