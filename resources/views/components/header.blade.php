<header class="navbar sticky-top bg-dark flex-md-nowrap py-2 shadow" data-bs-theme="dark">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="{{ url('/') }}">{{ config('app.name') }}</a>
  @auth
  <ul class="navbar-nav flex-row d-md-none">
    <li class="nav-item text-nowrap">
      <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle search">
        <svg class="bi"><use xlink:href="#search"/></svg>
      </button>
    </li>
    <li class="nav-item text-nowrap">
      <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <svg class="bi"><use xlink:href="#list"/></svg>
      </button>
    </li>
  </ul>

  <div class="dropdown d-none d-md-block d-lg-block" style="right: 70px;">
    <button class="bg-dark dropdown-toggle border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ Auth::user()->name }}
    </button>
    <ul class="dropdown-menu">
      <li>    <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
             document.getElementById('logout-form').submit();">
        {{ __('Logout') }}
    </a>  <form id="logout-form" action="{{ route('logout') }}" method="POST"
    class="d-none">
    @csrf
</form></li>
  
    </ul>
  </div>
  @else
  <div>
    <a class="btn btn-success" href="{{ url('/') }}">Login</a>
    <a class="btn btn-success" href="{{ route('register') }}">{{ __('Register') }}</a>
  </div>
 
  @endauth

  <div id="navbarSearch" class="navbar-search w-100 collapse">
      <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search"
          aria-label="Search">
  </div>
  
</header>