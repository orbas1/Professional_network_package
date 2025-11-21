@props(['activePage' => 'home'])

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo mr-auto"><a href="/"><img src="{{config('config.assets.logo')}}" alt="{{config('config.basic.seo_desc')}}"></a></h1>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="{{ $activePage == 'home' ? 'active' : '' }}"><a href="/#home">Home</a></li>

          @if(config('config.website.enable_about_page'))
            <li class="{{ $activePage == 'about' ? 'active' : '' }}"><a href="/about">About</a></li>
          @endif

          @if(config('config.website.enable_events_page'))
            <li><a href="/events">Events</a></li>
          @endif

          @if(config('config.website.enable_faq_page'))
            <li class="{{ $activePage == 'faq' ? 'active' : '' }}"><a href="/faq">FAQs</a></li>
          @endif

          @if(config('config.website.enable_contact_page'))
            <li class="{{ $activePage == 'contact' ? 'active' : '' }}"><a href="/contact">Contact</a></li>
          @endif

        </ul>
      </nav><!-- .nav-menu -->

      @if (\Auth::check())
        <a href="/app/panel/dashboard" class="get-started-btn scrollto">Dashboard</a>
      @else
        <a href="/app/login" class="get-started-btn scrollto">Login</a>
      @endif

    </div>
  </header><!-- End Header -->
