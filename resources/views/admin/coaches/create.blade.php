<x-app-layout>
    <x-slot name="header">Tambah Coach</x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Form Tambah Coach</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.coaches.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Coach</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Masukkan email" required>
                        </div>
                        <div class="form-group">
                            <label>Spesialisasi</label>
                            <select name="specialization" class="form-control" required>
                                <option value="fitness">Fitness Coach</option>
                                <option value="nutritionist">Nutritionist</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Konfirmasi Password" required>
                        </div>
                        <div class="card-action">
                            <button class="btn btn-success">Simpan</button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>