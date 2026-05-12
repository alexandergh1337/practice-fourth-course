@extends('layouts.app')

@section('content')
<section class="rounded-4 overflow-hidden position-relative text-white shadow" style="
    background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('img/hero.jpg') }}') center/cover no-repeat;
    padding: 100px 20px;
">
    <article class="container text-center py-5">
        <h1 class="display-3 fw-bold mb-3">Я буду кушац</h1>
        <p class="lead mb-5 mx-auto" style="max-width: 700px;">
            Забронируйте столик в лучшем ресторане города всего за пару кликов. Уют, изысканная кухня и безупречный сервис ждут вас.
        </p>
            <a href="#" class="btn btn-lg btn-success px-5 fw-bold text-white">
                Забронировать
            </a>
    </article>
</section>

<h2 class="text-center mt-5 fw-bold">Наши преимущества</h2>

<section class="row mt-4 g-4 text-center text-white">
    <article class="col-12 col-md-4">
        <article class="p-4 shadow-sm h-100" style="background-color: #a12323; border-radius: 30px;">
            <h5 class="fw-bold mb-0">Быстро</h5>
        </article>
    </article>
    <article class="col-12 col-md-4">
        <article class="p-4 shadow-sm h-100" style="background-color: #a12323; border-radius: 30px;">
            <h5 class="fw-bold mb-0">Удобно</h5>
        </article>
    </article>
    <article class="col-12 col-md-4">
        <article class="p-4 shadow-sm h-100" style="background-color: #a12323; border-radius: 30px;">
            <h5 class="fw-bold mb-0">Вкусно</h5>
        </article>
    </article>
</section>

<h2 class="text-center mt-5 fw-bold">Наш интерьер</h2>

<section id="Carousel" class="carousel slide mt-4 shadow rounded-4 overflow-hidden" data-bs-ride="carousel">
    <article class="carousel-inner">
        <article class="carousel-item active">
            <article style="height: 400px; background: #333 url('{{ asset('img/slide1.jpg') }}') center/cover;"></article>
            <article class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.5); border-radius: 10px;">
                <h5>Основной зал</h5>
                <p>Просторное помещение для больших компаний.</p>
            </article>
        </article>
        <article class="carousel-item">
            <article style="height: 400px; background: #444 url('{{ asset('img/slide2.jpg') }}') center/cover;"></article>
            <article class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.5); border-radius: 10px;">
                <h5>Уютная веранда</h5>
                <p>Насладитесь свежим воздухом и видом на город.</p>
            </article>
        </article>
        <article class="carousel-item">
            <article style="height: 400px; background: #555 url('{{ asset('img/slide3.jpg') }}') center/cover;"></article>
            <article class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.5); border-radius: 10px;">
                <h5>VIP-комната</h5>
                <p>Идеальное место для деловых встреч или романтического ужина.</p>
            </article>
        </article>
    </article>

    <button class="carousel-control-prev" type="button" data-bs-target="#Carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#Carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</section>
@endsection
