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
                            <a href="{{ route('login') }}" class="btn-default">Login</a>
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