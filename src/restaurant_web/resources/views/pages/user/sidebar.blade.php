<button class="btn btn-dark d-lg-none mb-3" id="sidebarToggle" style="position:fixed;top:18px;left:18px;z-index:1051;"><i class="fa fa-bars"></i></button>
<div class="user-sidebar px-3 pt-4 pb-2" id="userSidebar">
    <div class="sidebar-logo mb-4 text-center">
        <span class="fw-bold fs-3" style="color:#fff;letter-spacing:1px;">EatzAI</span>
    </div>
    <div class="profile-card card mb-4 mx-auto p-3 shadow-sm" style="max-width: 220px; border-radius: 16px;">
        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=ff8800&color=fff' }}" class="avatar mb-2 mx-auto" alt="Avatar">
        <div class="name">{{ Auth::user()->name }}</div>
        <div class="email">{{ Auth::user()->email }}</div>
    </div>
    <div class="list-group list-group-flush gap-2">
        <a href="{{ route('user.dashboard') }}" class="list-group-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
        <a href="{{ route('user.profile') }}" class="list-group-item {{ request()->routeIs('user.profile') ? 'active' : '' }}"><i class="fa fa-user"></i> Profile</a>
        <a href="{{ route('user.orders') }}" class="list-group-item {{ request()->routeIs('user.orders') ? 'active' : '' }}"><i class="fa fa-receipt"></i> Orders</a>
        <a href="{{ route('user.reservations') }}" class="list-group-item {{ request()->routeIs('user.reservations') ? 'active' : '' }}"><i class="fa fa-calendar-check"></i> Reservations</a>
        <a href="{{ route('user.change-password') }}" class="list-group-item {{ request()->routeIs('user.change-password') ? 'active' : '' }}"><i class="fa fa-key"></i> Change Password</a>
    </div>
    <div class="mt-4 pt-3 text-center">
        <a href="{{ route('home') }}" class="btn btn-outline-warning w-100 mb-2" style="border-width:2px; font-weight:600;">
            <i class="fa fa-arrow-left me-2"></i>Back to Website
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100" style="border-width:2px; font-weight:600;">
                <i class="fa fa-sign-out-alt me-2"></i>Logout
            </button>
        </form>
    </div>
</div>

@push('styles')
<style>
.user-sidebar {
    background: #23272b;
    color: #fff;
    border-radius: 18px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.08);
    border-right: 2px solid #ececec;
    min-width: 260px;
    max-width: 280px;
    transition: left 0.3s, box-shadow 0.3s;
}
.user-sidebar .sidebar-logo {
    margin-bottom: 1.5rem;
}
.user-sidebar .profile-card {
    background: #fff;
    color: #23272b;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    text-align: center;
    border: none;
}
.user-sidebar .profile-card .avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #ff8800;
    margin-bottom: 0.5rem;
}
.user-sidebar .profile-card .name {
    font-weight: 700;
    font-size: 1.08rem;
    color: #23272b;
}
.user-sidebar .profile-card .email {
    font-size: 0.97rem;
    color: #ff8800;
    word-break: break-all;
}
.user-sidebar .list-group {
    background: transparent;
    gap: 0.5rem;
}
.user-sidebar .list-group-item {
    background: transparent;
    color: #fff;
    border: none;
    font-size: 1.08rem;
    padding: 0.85rem 1.2rem;
    border-radius: 8px;
    margin-bottom: 0.2rem;
    transition: background 0.2s, color 0.2s;
    display: flex;
    align-items: center;
    gap: 0.85rem;
}
.user-sidebar .list-group-item.active, .user-sidebar .list-group-item:hover {
    background: #ff8800;
    color: #fff;
}
.user-sidebar .list-group-item i {
    font-size: 1.18rem;
}
@media (max-width: 991px) {
    .user-sidebar {
        position: fixed;
        top: 0;
        left: -320px;
        height: 100vh;
        z-index: 1050;
        min-width: 260px;
        max-width: 80vw;
        border-radius: 0 18px 18px 0;
        box-shadow: 2px 0 16px rgba(0,0,0,0.18);
        overflow-y: auto;
    }
    .user-sidebar.active {
        left: 0;
    }
    body.sidebar-open {
        overflow: hidden;
    }
}
#sidebarToggle {
    display: none;
}
@media (max-width: 991px) {
    #sidebarToggle {
        display: block;
    }
}
.user-portal-bg { background: #18191a; min-height: 100vh; }
.user-main-card { background: #fff; border-radius: 18px; box-shadow: 0 2px 16px rgba(0,0,0,0.08); padding: 2rem 2rem 1.5rem 2rem; margin-top: 2.5rem; }
@media (max-width: 991px) { .user-main-card { padding: 1rem; margin-top: 1rem; } }
</style>
@endpush
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.getElementById('userSidebar');
    var toggle = document.getElementById('sidebarToggle');
    if (toggle && sidebar) {
        toggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            document.body.classList.toggle('sidebar-open');
        });
        // Close sidebar when clicking outside
        document.addEventListener('click', function(e) {
            if (sidebar.classList.contains('active') && !sidebar.contains(e.target) && e.target !== toggle) {
                sidebar.classList.remove('active');
                document.body.classList.remove('sidebar-open');
            }
        });
    }
});
</script>
@endpush 