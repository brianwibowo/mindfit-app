<x-app-layout>
    <x-slot name="header">Edit Coach</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Form Edit Coach</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.coaches.update', $coach->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama Coach</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $coach->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email', $coach->email) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Nomor WhatsApp</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Contoh: 08123456789" value="{{ old('phone', $coach->phone) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Spesialisasi</label>
                            <select name="specialization" class="form-control" required>
                                <option value="fitness" {{ $coach->specialization == 'fitness' ? 'selected' : '' }}>
                                    Fitness Coach</option>
                                <option value="nutritionist" {{ $coach->specialization == 'nutritionist' ? 'selected' : '' }}>Nutritionist</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Password (Biarkan kosong jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password Baru">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Konfirmasi Password Baru">
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Update Data</button>
                            <a href="{{ route('admin.coaches.index') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>