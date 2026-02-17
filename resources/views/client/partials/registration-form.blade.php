@php
    $isEdit = isset($payment);
    $actionUrl = $isEdit ? route('client.payment.update', $payment->id) : route('client.payment.store');
    // Pre-fill values if edit mode
    $currentPackageId = $isEdit ? $payment->package_data['package_name'] : null; // Note: package_name isn't ID. Let's use logic or existing payment package_id if we have it on model.
    // Actually payment model has package_id column ? Yes from controller logic.
    $currentPackageId = $isEdit ? $payment->package_id : null;
    $hasMealPlan = $isEdit ? ($payment->package_data['addon_meal_plan'] ?? false) : false;
@endphp

<form id="paymentForm" action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('PATCH')
    @endif

    {{-- 1. DATA DIRI --}}
    <h5 class="text-primary mb-3">1. Data Diri</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" class="form-control" value="{{ $user->name }}" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" value="{{ $user->email }}" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Nomor WhatsApp <span class="text-danger">*</span></label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required
                    placeholder="0812...">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Alamat Domisili <span class="text-danger">*</span></label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}"
                    required placeholder="Jl. ...">
            </div>
        </div>
    </div>

    <hr>

    {{-- 2. PILIH PAKET --}}
    <h5 class="text-primary mb-3">2. Pilihan Paket</h5>
    @php
        // Group Packages logic
        $categories = [
            'Private Class' => [],
            'Squad (Group)' => [],
            'Academy (Team)' => [],
            'Nutritionist' => [],
            'Lainnya' => []
        ];
        
        foreach($packages as $p) {
            if (str_contains($p->name, '[Private]')) $categories['Private Class'][] = $p;
            elseif (str_contains($p->name, '[Group]')) $categories['Squad (Group)'][] = $p;
            elseif (str_contains($p->name, '[Academy]')) $categories['Academy (Team)'][] = $p;
            elseif (str_contains($p->name, '[Nutrition]')) $categories['Nutritionist'][] = $p;
            else $categories['Lainnya'][] = $p;
        }
    @endphp

    <div id="packageAccordion">
        @foreach($categories as $catName => $items)
            @if(count($items) > 0)
                <div class="card mb-2 border">
                    <div class="card-header p-2 bg-light" id="heading{{ Str::slug($catName) }}" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#collapse{{ Str::slug($catName) }}">
                        <h6 class="mb-0 text-primary fw-bold">
                            <i class="fas fa-chevron-right me-2 small"></i> {{ $catName }}
                        </h6>
                    </div>

                    <div id="collapse{{ Str::slug($catName) }}" class="collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#packageAccordion">
                        <div class="card-body p-2">
                            @foreach($items as $pkg)
                                <div class="form-check p-2 border-bottom d-flex align-items-center justify-content-between hover-bg-light">
                                    <div>
                                        <input class="form-check-input package-radio" type="radio" 
                                            name="package_id" 
                                            id="pkg{{ $pkg->id }}" 
                                            value="{{ $pkg->id }}"
                                            data-price="{{ $pkg->price }}"
                                            {{ (old('package_id') == $pkg->id || ($isEdit ? $currentPackageId == $pkg->id : false)) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold ms-2" for="pkg{{ $pkg->id }}">
                                            {{ str_replace(['[Private] ', '[Group] ', '[Academy] ', '[Nutrition] '], '', $pkg->name) }}
                                        </label>
                                        <div class="small text-muted ms-4">
                                            Rp {{ number_format($pkg->price, 0, ',', '.') }} 
                                            <span class="badge bg-secondary ms-1">{{ $pkg->duration_days }} Hari</span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-info rounded-circle" 
                                        onclick="showPackageDetails('{{ $pkg->name }}', `{{ $pkg->description }}`)">
                                        <i class="fas fa-info"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    {{-- Modal Details --}}
    <div class="modal fade" id="packageDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="pkgModalTitle">Detail Paket</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="pkgModalBody">
                    <!-- Content -->
                </div>
                <div class="modal-footer p-1">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-info mt-3">
        <h4>Total Tagihan: Rp <span id="totalTagihan">0</span></h4>
    </div>

    <hr>

    {{-- 3. PEMBAYARAN --}}
    <h5 class="text-primary mb-3">3. Pembayaran & Konfirmasi</h5>
    <div class="p-3 bg-light mb-3 rounded">
        <h6 class="fw-bold mb-2 text-primary">Transfer Bank (a.n RIO SETIOBUDI):</h6>
        <ul class="list-unstyled mb-3 ms-2">
            <li><span class="fw-bold" style="width: 140px; display: inline-block;">BRI</span> : 6820-01-024177-53-6</li>
            <li><span class="fw-bold" style="width: 140px; display: inline-block;">BSI</span> : 7294376733</li>
            <li><span class="fw-bold" style="width: 140px; display: inline-block;">Jago Syariah</span> : 508542930068</li>
        </ul>
        
        <h6 class="fw-bold mb-2 text-primary">E-Wallet:</h6>
        <ul class="list-unstyled mb-0 ms-2">
            <li><span class="fw-bold" style="width: 140px; display: inline-block;">Shopee Pay</span> : 085642501572</li>
            <li><span class="fw-bold" style="width: 140px; display: inline-block;">GO-PAY</span> : 085869155931</li>
        </ul>
        <hr class="my-2">
        <small class="text-muted"><i class="fas fa-info-circle me-1"></i> Konfirmasi pembayaran ke Admin: <b>0851-9961-5786</b> (WhatsApp)</small>
    </div>

    <div class="form-group">
        <label>Upload Bukti Transfer <span class="text-danger">{{ $isEdit ? '' : '*' }}</span></label>
        @if($isEdit && $payment->proof_file)
            <div class="mb-2">
                <small class="text-muted d-block mb-1">Bukti Saat Ini:</small>
                <img src="{{ asset('storage/' . $payment->proof_file) }}" height="100" class="rounded border">
            </div>
        @endif
        <input type="file" name="proof_file" class="form-control" {{ $isEdit ? '' : 'required' }}>
        <small class="text-muted">JPG, PNG, PDF. Max 5MB.
            {{ $isEdit ? '(Biarkan kosong jika tidak ingin mengubah bukti bayar)' : '' }}</small>
    </div>

    <div class="form-check">
        <label class="form-check-label">
            <input class="form-check-input" type="checkbox" required>
            <span class="form-check-sign">Saya menyetujui syarat & ketentuan yang berlaku.</span>
        </label>
    </div>

    <div class="form-action mt-4">
        <button type="submit"
            class="btn btn-success w-100">{{ $isEdit ? 'Simpan Perubahan' : 'Kirim Pendaftaran' }}</button>
    </div>
</form>

@push('scripts')
    <script>
        $(document).ready(function () {
            // Store the currently selected radio value
            var lastCheckedRadio = $('input[name="package_id"]:checked');
            var lastCheckedValue = lastCheckedRadio.length > 0 ? lastCheckedRadio.val() : null;

            // Function to update total price
            function updateTotal() {
                var pkgPrice = 0;
                var checkedRadio = $('input[name="package_id"]:checked');
                
                if (checkedRadio.length > 0) {
                    pkgPrice = parseInt(checkedRadio.data('price')) || 0;
                }

                // Removed meal plan logic
                $('#totalTagihan').text(pkgPrice.toLocaleString('id-ID'));
            }

            // Radio Click Event for Toggling
            $(document).on('click', 'input[name="package_id"]', function() {
                var $this = $(this);
                var val = $this.val();
                
                // 1. Force uncheck others (Fix for "bisa pilih > 1")
                $('input[name="package_id"]').not($this).prop('checked', false);

                // 2. Toggle Logic (Uncheck if clicking the active one)
                if (lastCheckedValue === val) {
                    $this.prop('checked', false);
                    lastCheckedValue = null;
                } else {
                    lastCheckedValue = val;
                }
                
                updateTotal();
            });

            // Init
            updateTotal();
        });

        // Global function for Modal (outside ready/scope to be accessible by onclick)
        function showPackageDetails(name, description) {
            // Remove prefix for display
            var cleanName = name.replace(/\[.*?\]\s?/g, '');
            $('#pkgModalTitle').text(cleanName);
            $('#pkgModalBody').html(description);
            var myModal = new bootstrap.Modal(document.getElementById('packageDetailModal'));
            myModal.show();
        }
    </script>
@endpush