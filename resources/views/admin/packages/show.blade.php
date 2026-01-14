<x-app-layout>
    <x-slot name="header">Detail Paket</x-slot>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title">{{ $package->name }}</div>
                    <span class="badge badge-{{ $package->type == 'fitness' ? 'primary' : 'success' }}">
                        {{ ucfirst($package->type) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($package->image)
                                <img src="{{ asset('storage/' . $package->image) }}" class="img-fluid rounded mb-3"
                                    alt="Thumbnail">
                            @else
                                <div class="p-5 bg-light text-center rounded mb-3">No Image</div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h3 class="text-primary font-weight-bold">Rp
                                {{ number_format($package->price, 0, ',', '.') }}</h3>
                            <p class="text-muted"><i class="far fa-clock"></i> Durasi: {{ $package->duration_days }}
                                Hari</p>
                            <hr>
                            <h5>Deskripsi & Fasilitas</h5>
                            <p style="white-space: pre-line;">{{ $package->description }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <a href="{{ route('admin.packages.edit', $package->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>