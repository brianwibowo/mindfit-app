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
                        <div class="col-md-5">
                            @php
                                $images = json_decode($package->image);
                                // Fallback for old single image string if valid
                                if (json_last_error() !== JSON_ERROR_NONE && !is_array($images) && $package->image) {
                                    $images = [$package->image];
                                } elseif (!$images && $package->image) {
                                    $images = [$package->image]; // handle edge case
                                }
                            @endphp

                            @if($images && count($images) > 0)
                                <div id="carouselPackage" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner rounded">
                                        @foreach($images as $key => $img)
                                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $img) }}" class="d-block w-100"
                                                    alt="Product Image" style="height: 300px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                    @if(count($images) > 1)
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselPackage"
                                            data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselPackage"
                                            data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    @endif
                                </div>
                                {{-- Thumbnail indicators --}}
                                <div class="d-flex mt-2" style="overflow-x: auto;">
                                    @foreach($images as $key => $img)
                                        <img src="{{ asset('storage/' . $img) }}" class="img-thumbnail me-2"
                                            style="width: 60px; height: 60px; object-fit: cover; cursor: pointer"
                                            onclick="document.querySelector('#carouselPackage').carousel({{ $key }})">
                                    @endforeach
                                </div>
                            @else
                                <div class="p-5 bg-light text-center rounded mb-3">No Image</div>
                            @endif
                        </div>
                        <div class="col-md-7">
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