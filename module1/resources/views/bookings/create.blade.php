@extends('layouts.app')

@section('content')
<article class="row justify-content-center">
    <article class="col-md-8">
        <article class="card shadow border-0">
            <article class="card-header bg-primary text-white p-3">
                <h4 class="mb-0">Новая заявка на уборку</h4>
            </article>
            <article class="card-body p-4">
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <article class="mb-3">
                        <label class="form-label">Вид услуги</label>
                        <select name="service_id" class="form-select" required>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }} ({{ $service->price }} руб.)</option>
                            @endforeach
                        </select>
                    </article>

                    <article class="mb-3">
                        <label class="form-label">Адрес уборки</label>
                        <input type="text" name="address" class="form-control" value="{{ Auth::user()->address ?? '' }}" required>
                    </article>

                    <article class="mb-3">
                        <label class="form-label">Желаемая дата и время</label>
                        <input type="datetime-local" name="scheduled_at" class="form-control" required>
                    </article>

                    <article class="mb-4">
                        <label class="form-label">Способ оплаты</label>
                        <article class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" value="Наличные" id="pay1" checked>
                            <label class="form-check-label" for="pay1">Наличными</label>
                        </article>
                        <article class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" value="Карта" id="pay2">
                            <label class="form-check-label" for="pay2">Банковской картой</label>
                        </article>
                    </article>

                    <article class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Отправить заявку</button>
                    </article>
                </form>
            </article>
        </article>
    </article>
</article>
@endsection
