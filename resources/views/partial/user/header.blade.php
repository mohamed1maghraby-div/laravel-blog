<div class="page-loader">
  <div class="loader">Loading...</div>
</div>
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#custom-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('user.index') }}">Titan</a>
    </div>
    <div class="collapse navbar-collapse" id="custom-collapse">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="{{ route('user.index') }}">Home</a></li>
        <li><a href="{{ route('posts.show', 'about-us') }}" >About Us</a></li>
        <li><a href="{{ route('posts.show', 'our-vision') }}" >Our Vision</a></li>
        <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Blog</a>
          <ul class="dropdown-menu" role="menu">
            @foreach ($global_categories as $global_category)
              <li><a href="{{ route('user.category', $global_category->slug) }}" >{{ $global_category->name }}</a></li>
            @endforeach
          </ul>
        </li>
        <li><a href="{{ route('user.contact') }}">Contact</a></li>
        @auth
          <user-notification></user-notification>
        @endauth
        <li>
          <ul>
            <li class="maghro-account">
              <a class="setting_active" href="#"><div class="maghro-account-icon"></div></a>
            </li>

            <div class="searchbar__content setting__block">
									<div class="content-inner">
										<div class="switcher-currency">
											<strong class="label switcher-label">
												<span>My Account</span>
											</strong>
											<div class="switcher-options">
												<div class="switcher-currency-trigger">
													<div class="setting__menu">
                              @guest
                                <span><a href="{{ route('login') }}">Login</a></span>
                                <span><a href="{{ route('register') }}">Register</a></span>
                              @else
                                <span><a href="{{ route('user.dashboard') }}">My Dashboard</a></span>
                                <span><a href="{{ route('logout') }}" onClick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></span>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                              @endguest
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>