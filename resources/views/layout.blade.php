<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', '')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
        .navbar {
            padding: 10px;
            background-color: #f8f9fa; /* Customize the background color */
        }

        .navbar-nav {
            margin-left: auto;
        }

        .navbar-text {
            margin-right: 15px;
        }

        .navbar-nav .nav-link {
            margin-right: 15px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            {{-- <a class="navbar-brand" href="{{ route('login') }}">{{ config('app.name') }}</a> --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('login') }}">Home</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('registration') }}">Registration</a>
                    </li>
                    @endauth
                </ul>
                <span class="navbar-text">@auth{{ auth()->user()->name }}@endauth</span>
            </div>
        </div>
    </nav>


    <div class="container-fluid">
        @if(!request()->is('login') && !request()->is('registration'))
            @include('include.sidebar')
        @endif
    </div>

    @auth
        @yield('dashboard')
    @endauth

    <div>
      @yield('content')
      @yield('scripts')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>