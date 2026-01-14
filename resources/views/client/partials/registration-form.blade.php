<form action="{{ route('client.payment.store') }}" method="POST" enctype="multipart/form-data" x-data="{ 
    selectedPkgPrice: 0, 
    mealPlan: false,
    updateTotal() {
        return parseInt(this.selectedPkgPrice) + (this.mealPlan ? 400000 : 0);
    }
}">
    @csrf

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
        <select name="package_id" class="form-control" required
            x-on:change="selectedPkgPrice = $event.target.selectedOptions[0].dataset.price">
            <option value="" data-price="0">-- Pilih Paket --</option>
            @foreach($packages as $pkg)
                <option value="{{ $pkg->id }}" data-price="{{ $pkg->price }}">
                    {{ $pkg->name }} - Rp {{ number_format($pkg->price, 0, ',', '.') }} ({{ $pkg->duration_days }} Hari)
                </option>
            @endforeach
        </select>
    </div>

    {{-- ADD-ON --}}
    <div class="form-check">
        <label class="form-check-label">
            <input class="form-check-input" type="checkbox" name="meal_plan" value="1" x-model="mealPlan">
            <span class="form-check-sign">Tambah Meal Plan (+ Rp 400.000)</span>
        </label>
        <small class="form-text text-muted d-block">Mendapatkan sesi eksklusif 4x sebulan.</small>
    </div>

    <div class="alert alert-info mt-3">
        <h4>Total Tagihan: Rp <span x-text="updateTotal().toLocaleString('id-ID')">0</span></h4>
    </div>

    <hr>

    {{-- 3. PEMBAYARAN --}}
    <h5 class="text-primary mb-3">3. Pembayaran & Konfirmasi</h5>
    <div class="p-3 bg-light mb-3 rounded">
        <p class="mb-1"><b>Bank Mandiri:</b> 1800015799309 (a.n MINDFIT)</p>
        <p class="mb-0"><b>E-Wallet (Dana/OVO):</b> 085719713074</p>
    </div>

    <div class="form-group">
        <label>Upload Bukti Transfer <span class="text-danger">*</span></label>
        <input type="file" name="proof_file" class="form-control" required>
        <small class="text-muted">JPG, PNG, PDF. Max 5MB.</small>
    </div>

    <div class="form-check">
        <label class="form-check-label">
            <input class="form-check-input" type="checkbox" required>
            <span class="form-check-sign">Saya menyetujui syarat & ketentuan yang berlaku.</span>
        </label>
    </div>

    <div class="form-action mt-4">
        <button type="submit" class="btn btn-success w-100">Kirim Pendaftaran</button>
    </div>
</form>