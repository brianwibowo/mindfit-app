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
    <div class="form-group">
        <label>Pilih Paket Langganan <span class="text-danger">*</span></label>
        <select name="package_id" id="packageSelect" class="form-control" required>
            <option value="" data-price="0">-- Pilih Paket --</option>
            @foreach($packages as $pkg)
                <option value="{{ $pkg->id }}" data-price="{{ $pkg->price }}" {{ (old('package_id') == $pkg->id || ($isEdit && $currentPackageId == $pkg->id)) ? 'selected' : '' }}>
                    {{ $pkg->name }} - Rp {{ number_format($pkg->price, 0, ',', '.') }} ({{ $pkg->duration_days }} Hari)
                </option>
            @endforeach
        </select>
    </div>

    {{-- ADD-ON --}}
    <div class="form-check">
        <label class="form-check-label">
            <input class="form-check-input" type="checkbox" name="meal_plan" id="mealPlanCheck" value="1" {{ (old('meal_plan') || $hasMealPlan) ? 'checked' : '' }}>
            <span class="form-check-sign">Tambah Meal Plan (+ Rp 400.000)</span>
        </label>
        <small class="form-text text-muted d-block">Mendapatkan sesi eksklusif 4x sebulan.</small>
    </div>

    <div class="alert alert-info mt-3">
        <h4>Total Tagihan: Rp <span id="totalTagihan">0</span></h4>
    </div>

    <hr>

    {{-- 3. PEMBAYARAN --}}
    <h5 class="text-primary mb-3">3. Pembayaran & Konfirmasi</h5>
    <div class="p-3 bg-light mb-3 rounded">
        <p class="mb-1"><b>Bank Mandiri:</b> 1800015799309 (a.n MINDFIT)</p>
        <p class="mb-0"><b>E-Wallet (Dana/OVO):</b> 085719713074</p>
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
            function updateTotal() {
                var pkgPrice = parseInt($('#packageSelect').find(':selected').data('price')) || 0;
                var mealAddon = $('#mealPlanCheck').is(':checked') ? 400000 : 0;
                var total = pkgPrice + mealAddon;
                $('#totalTagihan').text(total.toLocaleString('id-ID'));
            }

            $('#packageSelect, #mealPlanCheck').on('change', updateTotal);
            updateTotal(); // Init
        });
    </script>
@endpush