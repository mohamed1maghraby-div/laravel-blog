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
          <li>
            <ul>
              <li class="maghro-bell shopcart">
                <a class="cartbox_active" href="#"><div class="maghro-bell-icon"><span class="maghro-bell-span">3</span></div></a>
                <div class="block-minicart minicart__active">
                    <div class="minicart-content-wrapper">
                      <div class="micart__close">
                        <span>close</span>
                      </div>
                      <div class="single__items">
                        <div class="miniproduct">

                          <div class="item01 d-flex">
                            <div class="thumb">
                              <a href="product-details.html"><img src="{{ asset('user/assets/images/icons/1.jpg') }}" alt="product images"></a>
                            </div>
                            <div class="content">
                              <a href="#"> You have new comment on your post: postTitle</a>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>  
              </li>
            </ul>
          </li>
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
                                <span><a href="#">My Dashboard</a></span>
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