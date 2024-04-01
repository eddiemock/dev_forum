<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mental Health Forum</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" rel="stylesheet">
    <!-- Updated Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- End of updated Bootstrap CSS link -->
    <script src="{{ asset('js/app.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="{{ asset('css/admin-dashboard.css') }}" rel="stylesheet">

        <!-- Bootstrap CSS -->
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

>


    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .navbar {
            background-color: #1176e1;
        }
        .navbar-brand, .nav-link {
            color: #495057 !important;
        }
        .nav-link {
            margin-right: 1rem;
        }
        .nav-link:hover {
            color: #adb5bd !important;
        }
        .dropdown-menu {
            background-color: #495057;
        }
        .dropdown-item {
            color: #f8f9fa;
        }
        .dropdown-item:hover {
            background-color: #6c757d;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="/">{{ __('Discussion Forum') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">{{ __('Home') }}</a>
                </li>
                <!-- Inserted Resources Link -->
                <li class="nav-item">
                    <a class="nav-link" href="/resources">{{ __('Resources') }}</a>
                </li>
                <!-- End Inserted Resources Link -->
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pages.profile', ['id' => auth()->user()->id]) }}">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">{{ __('Admin Dashboard') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Logout</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="/login">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register">{{ __('Register') }}</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @include('layouts.flash')
    @yield('content')
</div>
</body>
</html>
