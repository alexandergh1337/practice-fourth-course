<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Я буду кушац</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        .footer-link:hover {
            text-decoration: underline !important;
        }
    </style>
</head>
<body class="d-flex flex-column" style="min-height: 100vh;">

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #a12323;">
            <section class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                    <span class="fw-bold">Я буду кушац</span>
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <article class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Вход</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Регистрация</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Мои бронирования</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('applications.create') }}">Забронировать</a></li>
                            @if(auth()->user()->isAdmin())
                                <li class="nav-item"><a class="nav-link fw-bold text-warning" href="{{ route('admin.index') }}">Админка</a></li>
                            @endif
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-link nav-link">Выйти</button>
                                </form>
                            </li>
                        @endguest
                    </ul>
                </article>
            </section>
        </nav>
    </header>

    <main class="flex-grow-1">
        <section class="container py-4">
            @if(session('success'))
                <article class="alert alert-success rounded-3 shadow-sm border-0">{{ session('success') }}</article>
            @endif

            @if(session('error'))
                <article class="alert alert-danger rounded-3 shadow-sm border-0">{{ session('error') }}</article>
            @endif

            @yield('content')
        </section>
    </main>

    <footer class="py-4 text-white mt-auto" style="background-color: #5c1111;">
        <section class="container text-center">
            <article class="d-flex flex-column align-items-center">
                <h5 class="fw-bold mb-3">Я буду кушац</h5>
                <ul class="list-unstyled mb-3">
                    @guest
                        <li class="mb-2"><a href="{{ route('login') }}" class="text-white text-decoration-none footer-link">Вход</a></li>
                        <li class="mb-2"><a href="{{ route('register') }}" class="text-white text-decoration-none footer-link">Регистрация</a></li>
                    @else
                        <li class="mb-2"><a href="{{ route('dashboard') }}" class="text-white text-decoration-none footer-link">Мои бронирования</a></li>
                        <li class="mb-2"><a href="{{ route('applications.create') }}" class="text-white text-decoration-none footer-link">Забронировать</a></li>
                    @endguest
                </ul>
                <article class="pt-3 w-100" style="border-top: 1px solid rgba(255,255,255,0.2);">
                    <span class="small">&copy; 2026 Все права защищены</span>
                </article>
            </article>
        </section>
    </footer>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
