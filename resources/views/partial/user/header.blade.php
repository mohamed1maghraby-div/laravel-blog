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
        <li><a href="#" >About Us</a></li>
        <li><a href="#" >Our Vision</a></li>
        <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Blog</a>
          <ul class="dropdown-menu" role="menu">
            @foreach ($global_categories as $global_category)
              <li><a href="{{ route('user.category', $global_category->slug) }}" >{{ $global_category->name }}</a></li>
            @endforeach
          </ul>
        </li>
        <li><a href="{{ route('user.contact') }}">Contact</a></li>

{{--         <li class="dropdown"><a class="dropdown-toggle" href="documentation.html" data-toggle="dropdown">Documentation</a>
          <ul class="dropdown-menu">
            <li><a href="documentation.html#contact">Contact Form</a></li>
            <li><a href="documentation.html#reservation">Reservation Form</a></li>
            <li><a href="documentation.html#mailchimp">Mailchimp</a></li>
            <li><a href="documentation.html#gmap">Google Map</a></li>
            <li><a href="documentation.html#plugin">Plugins</a></li>
            <li><a href="documentation.html#changelog">Changelog</a></li>
          </ul>
        </li> --}}
      </ul>
    </div>
  </div>
</nav>