{{-- resources/views/layouts/partials/header.blade.php --}}
<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom" style="padding-top: 0px !important; padding-bottom: 0px !important; min-height: 52px !important; height: 52px !important;">
    <div class="container-fluid d-flex align-items-center" style="padding-top: 0px !important; padding-bottom: 0px !important; height: 100%;">
        <!-- Tour Button (Pojok Kiri Header) -->
        <ul class="navbar-nav topbar-nav align-items-center">
            @auth
                @if(Auth::user()->role === 'client' || Auth::user()->role === 'coach')
                    <li class="nav-item">
                        <button id="btnStartTour" class="btn btn-outline-primary btn-round btn-sm px-3 shadow-sm">
                            <i class="fas fa-compass me-1"></i> Mulai Panduan
                        </button>
                    </li>
                @endif
            @endauth
        </ul>

        <!-- Right Side Controls (Theme, Help, Profile) -->
        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            @auth
                <!-- Theme Mode Switcher -->
                <li class="nav-item dropdown hidden-caret me-2">
                    <a class="nav-link dropdown-toggle text-secondary" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" title="Ubah Tema" style="display: flex; align-items: center; justify-content: center; min-height: 40px;">
                        <i id="themeCurrentIcon" class="fas fa-sun fa-lg"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end animated fadeIn">
                        <li>
                            <button class="dropdown-item d-flex align-items-center py-2" onclick="setThemeMode('light')">
                                <i class="fas fa-sun me-2 text-warning"></i> Mode Terang
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item d-flex align-items-center py-2" onclick="setThemeMode('dark')">
                                <i class="fas fa-moon me-2 text-info"></i> Mode Gelap
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item d-flex align-items-center py-2" onclick="setThemeMode('system')">
                                <i class="fas fa-desktop me-2 text-secondary"></i> Sistem (OS)
                            </button>
                        </li>
                    </ul>
                </li>

                <!-- Pusat Informasi (Bantuan) Button -->
                <li class="nav-item me-3" id="btnHelpCenter">
                    <a class="nav-link text-secondary" href="#" data-bs-toggle="modal" data-bs-target="#helpCenterModal" title="Pusat Informasi" style="cursor: pointer; display: flex; align-items: center; justify-content: center; min-height: 40px;">
                        <i class="fas fa-question-circle fa-lg"></i>
                    </a>
                </li>

                <!-- Profile Pic Dropdown -->
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic d-flex align-items-center" data-bs-toggle="dropdown" href="#" aria-expanded="false" style="text-decoration: none;">
                        <div class="avatar-sm" style="width: 35px; height: 35px; min-width: 35px; height: 35px;">
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('kaiadmin/img/profile.jpg') }}"
                                onerror="this.onerror=null;this.src='{{ asset('kaiadmin/img/profile.jpg') }}';"
                                alt="..." class="avatar-img rounded-circle" style="width: 35px; height: 35px; object-fit: cover;" />
                        </div>
                        <span class="profile-username ms-2 text-start">
                            <span class="op-7" style="font-size: 10px; display: block; line-height: 1;">Hai,</span>
                            <span class="fw-bold" style="font-size: 13px; display: block; line-height: 1.2;">{{ Auth::user()->name }}</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="u-text w-100">
                                        <h4 class="fw-bold mb-1">{{ Auth::user()->name }}</h4>
                                        <p class="text-muted small mb-3">{{ Auth::user()->email }}</p>
                                        
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('profile.edit') }}" class="btn btn-xs btn-secondary btn-sm">
                                                <i class="fas fa-user me-1"></i> Edit Profil
                                            </a>
                                            <form method="POST" action="{{ route('logout') }}" class="d-grid w-100" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari sistem MindFit?');">
                                                @csrf
                                                <button type="submit" class="btn btn-xs btn-danger btn-sm text-white">
                                                    <i class="fas fa-sign-out-alt me-1"></i> Keluar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </div>
                    </ul>
                </li>
            @endauth
        </ul>
    </div>
</nav>