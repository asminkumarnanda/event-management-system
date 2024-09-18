<div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"
            aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 @if ((request()->is('home'))) active @endif" aria-current="page"
                    href="{{ route('home') }}">
                    <svg class="bi">
                        <use xlink:href="#house-fill" />
                    </svg>
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 @if ((request()->is('events*'))) active @endif" href="{{ route('events.index') }}">
                    <svg class="bi">
                        <use xlink:href="#file-earmark" />
                    </svg>
                    Events
                </a>
            </li>

            <hr class="d-md-none">
            <li class="nav-item d-md-none">
                <a class="nav-link d-flex align-items-center gap-2" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <svg class="bi">
                        <use xlink:href="#file-earmark" />
                    </svg>
                    {{ __('Logout') }}
                </a>
            </li>
        </ul>
    </div>
</div>
