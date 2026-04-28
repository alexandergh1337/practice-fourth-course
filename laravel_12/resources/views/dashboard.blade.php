@extends('layouts.app')

@section('content')
<article class="d-flex justify-content-between align-items-center mb-4">
    <h2>Мои заявки</h2>
    <a href="{{ route('bookings.create') }}" class="btn btn-primary shadow-sm">+ Новая заявка</a>
</article>

@if($bookings->isEmpty())
    <article class="alert alert-light text-center border p-5">
        <p class="text-muted mb-0">У вас пока нет активных заявок.</p>
    </article>
@else
    <article class="row">
        @foreach($bookings as $booking)
            <article class="col-12 mb-3">
                <article class="card border-0 shadow-sm rounded-custom">
                    <article class="card-body d-flex justify-content-between align-items-center p-4">
                        <article>
                            <h5 class="fw-bold mb-1">{{ $booking->service->name ?? 'Услуга' }}</h5>
                            <p class="mb-0 text-muted">
                                {{ $booking->address }} |
                                {{ \Carbon\Carbon::parse($booking->scheduled_at)->format('d.m.Y H:i') }}
                            </p>
                            <small class="text-secondary">Оплата: {{ $booking->payment_method }}</small>
                        </article>
                        <article class="text-end">
                            <span class="badge rounded-pill p-2 px-4
                                @if($booking->status == 'Новая') bg-primary
                                @elseif($booking->status == 'В работе') bg-warning text-dark
                                @elseif($booking->status == 'Выполнена') bg-success
                                @else bg-danger @endif">
                                {{ $booking->status }}
                            </span>
                            @if($booking->cancel_reason)
                                <article class="small text-danger mt-1">Причина: {{ $booking->cancel_reason }}</article>
                            @endif
                        </article>
                    </article>
                </article>
            </article>
        @endforeach
    </article>
@endif
@endsection
