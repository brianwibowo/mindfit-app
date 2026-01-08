{{-- Mengambil file di resources/views/layouts/app.blade.php --}}
@extends('layouts.app')

{{-- Mengisi variabel $header yang ada di app.blade.php --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Selamat Datang, Komandan!</div>
                </div>
                <div class="card-body">
                    <p>Jika halaman ini muncul dengan sidebar dan header KaiAdmin, berarti koneksi layout sudah <b>BERHASIL</b>.</p>
                    
                    <div class="alert alert-success">
                        Role Anda saat ini: <b>{{ auth()->user()->role ?? 'Guest (Belum Login)' }}</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection