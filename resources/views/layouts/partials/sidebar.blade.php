<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ Auth::check() ? (Auth::user()->role == 'admin' ? route('admin.dashboard') : (Auth::user()->role == 'coach' ? route('coach.dashboard') : route('client.dashboard'))) : url('/') }}"
                class="logo">
                <img src="{{ asset('storage/images/logo.png') }}" alt="navbar brand" class="navbar-brand" height="40">
                <span style="color: white; font-weight: bold; font-size: 18px; margin-left: 10px;">MINDFIT</span>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
            </div>
            <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
        </div>
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">

                {{-- ==================================================================================
                ROLE: ADMIN
                ================================================================================== --}}
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-section">
                        <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                        <h4 class="text-section">MANAJEMEN</h4>
                    </li>
                    <li
                        class="nav-item {{ request()->routeIs('admin.clients.*') || request()->routeIs('admin.coaches.*') ? 'active submenu' : '' }}">
                        <a data-bs-toggle="collapse" href="#manageUser">
                            <i class="fas fa-users-cog"></i>
                            <p>Manajemen User</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.clients.*') || request()->routeIs('admin.coaches.*') ? 'show' : '' }}"
                            id="manageUser">
                            <ul class="nav nav-collapse">
                                <li class="{{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.clients.index') }}">
                                        <span class="sub-item">Manage Klien</span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('admin.coaches.*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.coaches.index') }}">
                                        <span class="sub-item">Manage Coach & Nutritionist</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.packages.index') }}">
                            <i class="fas fa-box-open"></i>
                            <p>Manajemen Produk</p>
                        </a>
                    </li>

                    <li class="nav-section">
                        <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                        <h4 class="text-section">MONITORING</h4>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.sessions.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.sessions.index') }}">
                            <i class="fas fa-calendar-alt"></i>
                            <p>Monitoring Sesi</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.progress.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.progress.index') }}">
                            <i class="fas fa-chart-line"></i>
                            <p>Monitoring Progress</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.ai.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.ai.index') }}">
                            <i class="fas fa-robot"></i>
                            <p>Analisa AI</p>
                        </a>
                    </li>
                @endif

                {{-- ==================================================================================
                ROLE: CLIENT
                ================================================================================== --}}
                {{-- ==================================================================================
                ROLE: CLIENT
                ================================================================================== --}}
                @if(Auth::check() && Auth::user()->role === 'client')
                    @php
                        $isPremium = Auth::user()->is_premium;
                    @endphp

                    {{-- FASE FREE --}}
                    @if(!$isPremium)
                        <li class="nav-item {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('client.dashboard') }}">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('client.ai.index') ? 'active' : '' }}">
                            <a href="{{ route('client.ai.index') }}">
                                <i class="fas fa-robot"></i>
                                <p>Fitur AI</p>
                            </a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('client.payment.create') ? 'active' : '' }}">
                            <a href="{{ route('client.payment.create') }}">
                                <i class="fas fa-file-signature"></i>
                                <p>Form Pendaftaran</p>
                            </a>
                        </li>
                    @endif

                    {{-- FASE PREMIUM --}}
                    @if($isPremium)
                        <li
                            class="nav-item {{ request()->routeIs('client.sessions.*') || request()->routeIs('client.progress.*') ? 'active submenu' : '' }}">
                            <a data-bs-toggle="collapse" href="#layananMenu">
                                <i class="fas fa-dumbbell"></i>
                                <p>Layanan</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse {{ request()->routeIs('client.sessions.*') || request()->routeIs('client.progress.*') ? 'show' : '' }}"
                                id="layananMenu">
                                <ul class="nav nav-collapse">
                                    <li
                                        class="{{ request()->routeIs('client.sessions.*') && request('type') == 'coach' ? 'active' : '' }}">
                                        <a href="{{ route('client.sessions.index', ['type' => 'coach']) }}">
                                            <span class="sub-item">Sesi Coach</span>
                                        </a>
                                    </li>
                                    <li
                                        class="{{ request()->routeIs('client.sessions.*') && request('type') == 'nutritionist' ? 'active' : '' }}">
                                        <a href="{{ route('client.sessions.index', ['type' => 'nutritionist']) }}">
                                            <span class="sub-item">Sesi Nutritionist</span>
                                        </a>
                                    </li>
                                    <li
                                        class="{{ request()->routeIs('client.progress.index') || request()->routeIs('client.progress.create') || request()->routeIs('client.progress.edit') || request()->routeIs('client.progress.show') ? 'active' : '' }}">
                                        <a href="{{ route('client.progress.index') }}">
                                            <span class="sub-item">Progress (Input)</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('client.progress.charts') ? 'active' : '' }}">
                                        <a href="{{ route('client.progress.charts') }}">
                                            <span class="sub-item">Hasil (Visualisasi)</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li
                            class="nav-item {{ request()->routeIs('client.dashboard') || request()->routeIs('client.ai.*') ? 'active submenu' : '' }}">
                            <a data-bs-toggle="collapse" href="#langgananMenu">
                                <i class="fas fa-crown"></i>
                                <p>Langganan</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse {{ request()->routeIs('client.dashboard') || request()->routeIs('client.ai.*') ? 'show' : '' }}"
                                id="langgananMenu">
                                <ul class="nav nav-collapse">
                                    <li class="{{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                                        <a href="{{ route('client.dashboard') }}">
                                            <span class="sub-item">Status Berlangganan</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('client.ai.*') ? 'active' : '' }}">
                                        <a href="{{ route('client.ai.index') }}">
                                            <span class="sub-item">Fitur AI</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('client.payment.create') }}">
                                            <span class="sub-item">Form Pendaftaran</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                @endif

                {{-- ==================================================================================
                ROLE: COACH / NUTRITIONIST
                ================================================================================== --}}
                @if(Auth::check() && Auth::user()->role === 'coach')
                    <li class="nav-item {{ request()->routeIs('coach.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('coach.dashboard') }}">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('coach.sessions.*') ? 'active' : '' }}">
                        <a href="{{ route('coach.sessions.index') }}">
                            <i class="fas fa-calendar-check"></i>
                            <p>Manajemen Sesi</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('coach.progress.*') ? 'active' : '' }}">
                        <a href="{{ route('coach.progress.index') }}">
                            <i class="fas fa-chart-line"></i>
                            <p>Monitoring Progress</p>
                        </a>
                    </li>
                @endif

                <li class="nav-item mt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-danger">
                            <i class="fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>