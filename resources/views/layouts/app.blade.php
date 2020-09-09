<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav>
            <div class="navbar-wrapper">
                <a class="brand-logo" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <ul id="nav-desktop" class="right hide-on-med-and-down">
                    <li>
                        <a href="#">Link</a>
                    </li>
                    @guest
                    <li>
                        <a href="{{ route('login') }}">Login</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}">Sign Up</a>
                    </li>
                    @else
                    <li>
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li>
                        <button class="btn dropdown-trigger" data-target="dropdown-user-desktop">{{ Auth::user()->username }}</button>
                         <ul id="dropdown-user-desktop" class="dropdown-content">
                            {{-- Logout --}}
                            <li>                                   
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </li>
                            @can('view.admin.dashboard')
                            <li>
                                <a href="{{ route('admin.index') }}">Admin Panel</a>
                            </li>
                            @endcan
                        </ul>
                    </li>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    @endif
                </ul>
            </div>
        </nav>
        
        <main>
            @yield('content')
        </main>
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    @yield('scripts')
</body>
</html>
