	<header class="main-header">
		<div class="header-sticky">
			<nav class="navbar navbar-expand-lg">
				<div class="container">
					<!-- Logo Start -->
					<a class="navbar-brand" href="{{ route('home') }}">
						<!-- <img src="{{ asset('images/logo.svg') }}" alt="Logo"> -->
						<h2> EatzAI </h2>
					</a>
					<!-- Logo End -->

					<!-- Main Menu Start -->
					<div class="collapse navbar-collapse main-menu">
                        <div class="nav-menu-wrapper">
                            <ul class="navbar-nav mr-auto" id="menu">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                                       href="{{ route('home') }}">Home</a>
                                </li>                                
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" 
                                       href="{{ route('about') }}">About Us</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('menu') ? 'active' : '' }}" 
                                       href="{{ route('menu') }}">Menu</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" 
                                       href="{{ route('contact') }}">Contact Us</a>
                                </li>                           
                            </ul>
                        </div>
                        <!-- Header Contact Box Start -->
                        <div class="header-btn">
                            @if(Auth::check())
                                <div class="dropdown d-inline-block">
                                    <a href="#" class="nav-link dropdown-toggle p-0" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="display: flex; align-items: center;">
                                        <span class="me-2 d-inline-block rounded-circle bg-light" style="width: 38px; height: 38px; overflow: hidden;">
                                            <img src="{{ Auth::user()->avatar ?? '' }}" onerror="this.style.display='none'" alt="Avatar" class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                                            <i class="fa fa-user-circle fa-2x text-secondary" style="position: absolute; left: 0; top: 0; width: 38px; height: 38px; display: block;" v-if="!this.src"></i>
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end shadow p-2" aria-labelledby="userDropdown" style="min-width: 220px;">
                                        <li class="px-3 py-2 border-bottom mb-1">
                                            <div class="fw-bold">{{ Auth::user()->name }}</div>
                                            <div class="small text-muted">{{ Auth::user()->email }}</div>
                                        </li>
                                        <li><a class="dropdown-item py-2" href="{{ route('user.profile') }}"><i class="fa fa-user me-2"></i>My Profile</a></li>
                                        <li><a class="dropdown-item py-2" href="{{ route('user.orders') }}"><i class="fa fa-receipt me-2"></i>My Orders</a></li>
                                        <li><a class="dropdown-item py-2" href="{{ route('user.reservations') }}"><i class="fa fa-calendar-check me-2"></i>My Reservations</a></li>
                                        <li><a class="dropdown-item py-2" href="{{ route('user.change-password') }}"><i class="fa fa-key me-2"></i>Change Password</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger py-2"><i class="fa fa-sign-out-alt me-2"></i>Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="btn-default">Login</a>
                            @endif
                        </div>
                        <!-- Header Contact Box End -->
					</div>
					<!-- Main Menu End -->
					<div class="navbar-toggle"></div>
				</div>
			</nav>
			<div class="responsive-menu"></div>
		</div>
	</header>