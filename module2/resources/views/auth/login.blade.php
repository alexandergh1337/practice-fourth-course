@extends('layouts.app')

@section('content')
<section class="row justify-content-center py-5">
    <article class="col-12 col-md-6 col-lg-4">
        <article class="card shadow-sm border-0 rounded-4 p-4">
            <h2 class="text-center fw-bold mb-4">Вход</h2>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <article class="mb-3">
                    <label for="login" class="form-label small fw-bold">Логин</label>
                    <input type="text" name="login" id="login" class="form-control @error('login') is-invalid @enderror" value="{{ old('login') }}" required autofocus>
                    @error('login') <article class="invalid-feedback">{{ $message }}</article> @enderror
                </article>

                <article class="mb-4">
                    <label for="password" class="form-label small fw-bold">Пароль</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password') <article class="invalid-feedback">{{ $message }}</article> @enderror
                </article>

                <button type="submit" class="btn btn-success w-100 fw-bold text-white">
                    Войти
                </button>

                <p class="text-center mt-3 small">
                    Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
                </p>
            </form>
        </article>
    </article>
</section>
@endsection
