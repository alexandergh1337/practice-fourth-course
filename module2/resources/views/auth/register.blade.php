@extends('layouts.app')

@section('content')
<section class="row justify-content-center py-5">
    <article class="col-12 col-md-6 col-lg-4">
        <article class="card shadow border-0 rounded-4 p-4">
            <h2 class="text-center fw-bold mb-4">Регистрация</h2>

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <article class="mb-3">
                    <label for="name" class="form-label small fw-bold">Имя</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Иван Иванов" required>
                    @error('name') <article class="invalid-feedback">{{ $message }}</article> @enderror
                </article>

                <article class="mb-3">
                    <label for="login" class="form-label small fw-bold">Логин</label>
                    <input type="text" name="login" id="login" class="form-control @error('login') is-invalid @enderror" value="{{ old('login') }}" placeholder="Login66" required>
                    @error('login') <article class="invalid-feedback">{{ $message }}</article> @enderror
                </article>

                <article class="mb-3">
                    <label for="email" class="form-label small fw-bold">Почта</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="email@example.com" required>
                    @error('email') <article class="invalid-feedback">{{ $message }}</article> @enderror
                </article>

                <article class="mb-3">
                    <label for="phone" class="form-label small fw-bold">Телефон</label>
                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="+7(999)-999-99-99" required>
                    @error('phone') <article class="invalid-feedback">{{ $message }}</article> @enderror
                </article>

                <article class="mb-3">
                    <label for="password" class="form-label small fw-bold">Пароль</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password') <article class="invalid-feedback">{{ $message }}</article> @enderror
                </article>

                <article class="mb-4">
                    <label for="password_confirmation" class="form-label small fw-bold">Подтверждение пароля</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </article>

                <button type="submit" class="btn btn-success w-100 fw-bold text-white">
                    Зарегистрироваться
                </button>

                <p class="text-center mt-3 small">
                    Уже есть аккаунт? <a class="text-secondary text-decoration-none" href="{{ route('login') }}">Войти</a>
                </p>
            </form>
        </article>
    </article>
</section>
@endsection
