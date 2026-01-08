{{-- resources/views/layouts/partials/sidebar.blade.php --}}

<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="#" class="logo" style="color: white; font-weight: bold; font-size: 20px;">
                MINDFIT
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
            </div>
        </div>
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item">
                    <a href="{{ url('/') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                    <h4 class="text-section">MENU UTAMA</h4>
                </li>

                @if(Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <p>Verifikasi Member</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#">
                            <i class="fas fa-user-tie"></i>
                            <p>Manage Coach</p>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->role === 'coach')
                    <li class="nav-item">
                        <a href="{{ route('coach.dashboard') }}">
                            <i class="fas fa-users"></i>
                            <p>Daftar Klien Saya</p>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->role === 'client')
                    <li class="nav-item">
                        <a href="{{ route('client.dashboard') }}">
                            <i class="fas fa-robot"></i>
                            <p>AI Fitness Plan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#">
                            <i class="fas fa-dumbbell"></i>
                            <p>Workout Plan</p>
                        </a>
                    </li>
                @endif
                
                <li class="nav-item mt-3">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-danger">
                            <i class="fas fa-sign-out-alt text-danger"></i>
                            <p>Logout</p>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>