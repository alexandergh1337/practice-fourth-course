@extends('layouts.app')

@section('content')
<h2 class="mb-4 fw-bold">Мои бронирования</h2>

<article class="row g-4">
    @forelse($applications as $app)
        <article class="col-12 col-md-6">
            <article class="card h-100 shadow border-0 rounded-4">
                <article class="card-body p-4">
                    <article class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="fw-bold mb-0">{{ $app->service->name }}</h5>
                        <span class="badge rounded-pill px-3 py-2
                            @if($app->status == 'Новая') bg-primary
                            @elseif($app->status == 'В работе' || $app->status == 'Посещение состоялось') bg-success
                            @else bg-danger @endif">
                            {{ $app->status }}
                        </span>
                    </article>

                    <ul class="list-unstyled small mb-3">
                        <li><strong>Дата и время:</strong> {{ $app->date }} в {{ $app->time }}</li>
                        <li><strong>Гостей:</strong> {{ $app->guests }}</li>
                        @if($app->details)
                            <li><strong>Детали/Адрес:</strong> {{ $app->details }}</li>
                        @endif
                    </ul>

                    @if($app->status == 'Отменена' && $app->cancel_reason)
                        <article class="p-3 bg-light rounded-3 mb-3 border-start border-danger border-4">
                            <strong class="small text-danger d-block mb-1">Причина отмены:</strong>
                            <p class="small mb-0">{{ $app->cancel_reason }}</p>
                        </article>
                    @endif

                    @if($app->status == 'Посещение состоялось')
                        @if(!$app->review)
                            <form action="{{ route('applications.review', $app) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <textarea name="review" class="form-control form-control-sm mb-2" placeholder="Оставьте отзыв о качестве обслуживания..." required></textarea>
                                <button class="btn btn-sm btn-outline-success">Отправить отзыв</button>
                            </form>
                        @else
                            <article class="p-3 bg-light rounded-3 border-start border-success border-4">
                                <strong class="small text-success d-block mb-1">Ваш отзыв:</strong>
                                <p class="small mb-0 italic">{{ $app->review }}</p>
                            </article>
                        @endif
                    @endif
                </article>
            </article>
        </article>
    @empty
        <article class="col-12 text-center py-5">
            <p class="text-muted">У вас пока нет бронирований.</p>
            <a href="{{ route('applications.create') }}" class="btn btn-success text-white">Забронировать сейчас</a>
        </article>
    @endforelse
</article>
@endsection
