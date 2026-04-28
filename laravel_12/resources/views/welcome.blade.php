@extends('layouts.app')

@section('content')
<article class="p-5 mb-4 text-white shadow rounded"
         style="background-image: url('https://picsum.photos/1200/600?cleaning'); background-size: cover; background-position: center; min-height: 400px; display: flex; align-items: center; justify-content: center;">
    <article class="text-center">
        <h1 class="display-5 fw-bold">Мой Не Сам</h1>
        <p class="fs-4">Профессиональный клининг для вашего комфорта.</p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4 mt-3">Заказать уборку</a>
    </article>
</article>

<article class="row g-4 py-5 text-center">
    <article class="col-md-4">
        <img src="https://picsum.photos/200/200?a" class="rounded-circle mb-3 border shadow-sm" width="100" height="100">
        <h3 class="fw-bold">Качество</h3>
        <p class="text-muted">Идеальная чистота во всех уголках.</p>
    </article>
    <article class="col-md-4">
        <img src="https://picsum.photos/200/200?b" class="rounded-circle mb-3 border shadow-sm" width="100" height="100">
        <h3 class="fw-bold">Скорость</h3>
        <p class="text-muted">Работаем быстро и профессионально.</p>
    </article>
    <article class="col-md-4">
        <img src="https://picsum.photos/200/200?c" class="rounded-circle mb-3 border shadow-sm" width="100" height="100">
        <h3 class="fw-bold">Гарантия</h3>
        <p class="text-muted">Мы ценим доверие наших клиентов.</p>
    </article>
</article>

<article id="mainCarousel" class="carousel slide mb-5 shadow-sm rounded overflow-hidden border" data-bs-ride="carousel">
    <article class="carousel-inner">
        <article class="carousel-item active" data-bs-interval="3000">
            <img src="https://picsum.photos/1200/400?1" class="d-block w-100" alt="...">
        </article>
        <article class="carousel-item" data-bs-interval="3000">
            <img src="https://picsum.photos/1200/400?2" class="d-block w-100" alt="...">
        </article>
    </article>
    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</article>
@endsection
