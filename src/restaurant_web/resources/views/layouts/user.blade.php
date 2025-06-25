<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'User Portal') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/user-portal.css') }}">
</head>
<body>

    <div class="portal-wrapper">
        <!-- Sidebar -->
        <aside class="portal-sidebar">
            <div class="d-flex flex-column h-100">
                <div class="text-center mb-4">
                    <a class="navbar-brand fs-4 fw-bold text-white" href="{{ route('home') }}">
                       {{ config('app.name')}}
                    </a>
                </div>
                
                <div class="sidebar-profile-card text-center mb-4">
                    <img src="https://i.pravatar.cc/150?u={{ auth()->id() }}" alt="User Avatar" class="avatar mb-2">
                    <h5 class="profile-name mb-0">{{ Auth::user()->name }}</h5>
                    <p class="profile-email">{{ Auth::user()->email }}</p>
                </div>

                <ul class="sidebar-nav flex-grow-1">
                    <li class="sidebar-nav-item">
                        <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt fa-fw"></i><span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile') ? 'active' : '' }}">
                            <i class="fas fa-user-circle fa-fw"></i><span>My Profile</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('user.orders') }}" class="{{ request()->routeIs('user.orders') ? 'active' : '' }}">
                            <i class="fas fa-shopping-bag fa-fw"></i><span>My Orders</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('user.reservations') }}" class="{{ request()->routeIs('user.reservations') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt fa-fw"></i><span>My Reservations</span>
                        </a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="{{ route('user.change-password') }}" class="{{ request()->routeIs('user.change-password') ? 'active' : '' }}">
                            <i class="fas fa-key fa-fw"></i><span>Change Password</span>
                        </a>
                    </li>
                </ul>

                <div class="mt-auto">
                    <a href="{{ route('logout') }}" class="btn btn-outline-secondary w-100"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="portal-main-content">
            <header class="portal-main-header d-lg-none">
                <button class="btn" id="sidebar-toggler"><i class="fas fa-bars"></i></button>
                <a class="navbar-brand fs-4 fw-bold text-white" href="{{ route('home') }}">
                   {{ config('app.name')}}
                </a>
            </header>

            <div class="p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
        
        <div class="portal-sidebar-overlay"></div>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggler = document.getElementById('sidebar-toggler');
            const portalWrapper = document.querySelector('.portal-wrapper');
            const overlay = document.querySelector('.portal-sidebar-overlay');

            if (sidebarToggler) {
                sidebarToggler.addEventListener('click', function () {
                    portalWrapper.classList.toggle('is-sidebar-open');
                });
            }
            
            if (overlay) {
                overlay.addEventListener('click', function() {
                    portalWrapper.classList.remove('is-sidebar-open');
                });
            }
        });
    </script>
</body>
</html> 