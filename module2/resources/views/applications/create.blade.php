@extends('layouts.app')

@section('content')
<section class="row justify-content-center">
    <article class="col-12 col-md-8 col-lg-6">
        <article class="card shadow border-0 rounded-4 p-4">
            <h2 class="mb-4 fw-bold">Забронировать столик</h2>

            <form action="{{ route('applications.store') }}" method="POST">
                @csrf

                <article class="mb-3">
                    <label for="service_id" class="form-label small fw-bold">Тип столика / Услуга</label>
                    <select name="service_id" id="service_id" class="form-select @error('service_id') is-invalid @enderror" required>
                        <option value="" disabled selected>Выберите вариант...</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>
                                {{ $service->name }} @if($service->price) ({{ $service->price }} руб.) @endif
                            </option>
                        @endforeach
                    </select>
                    @error('service_id') <article class="invalid-feedback">{{ $message }}</article> @enderror
                </article>

                <article class="row g-3 mb-3">
                    <article class="col-6">
                        <label for="date" class="form-label small fw-bold">Дата</label>
                        <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" required>
                        @error('date') <article class="invalid-feedback">{{ $message }}</article> @enderror
                    </article>
                    <article class="col-6">
                        <label for="time" class="form-label small fw-bold">Время</label>
                        <input type="time" name="time" id="time" class="form-control @error('time') is-invalid @enderror" value="{{ old('time') }}" required>
                        @error('time') <article class="invalid-feedback">{{ $message }}</article> @enderror
                    </article>
                </article>

                <article class="mb-3">
                    <label for="guests" class="form-label small fw-bold">Количество гостей (1-10)</label>
                    <input type="number" name="guests" id="guests" class="form-control @error('guests') is-invalid @enderror" value="{{ old('guests', 1) }}" min="1" max="10" required>
                    @error('guests') <article class="invalid-feedback">{{ $message }}</article> @enderror
                </article>

                <article class="mb-3">
                    <label for="phone" class="form-label small fw-bold">Контактный телефон</label>
                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', auth()->user()->phone) }}" placeholder="+7(XXX)-XXX-XX-XX" required>
                    @error('phone') <article class="invalid-feedback">{{ $message }}</article> @enderror
                </article>

                <article class="mb-3">
                    <label for="details" class="form-label small fw-bold">Дополнительные пожелания / Адрес</label>
                    <textarea name="details" id="details" class="form-control @error('details') is-invalid @enderror" rows="3" placeholder="Например: столик у окна или адрес доставки">{{ old('details') }}</textarea>
                    @error('details') <article class="invalid-feedback">{{ $message }}</article> @enderror
                </article>

                <article class="mb-4">
                    <label class="form-label small fw-bold d-block">Способ оплаты</label>
                    <article class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payment_method" id="pay_cash" value="Наличные" checked>
                        <label class="form-check-label small" for="pay_cash">Наличные</label>
                    </article>
                    <article class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="payment_method" id="pay_card" value="Карта">
                        <label class="form-check-label small" for="pay_card">Карта</label>
                    </article>
                </article>

                <button type="submit" class="btn btn-success w-100 fw-bold py-2 text-white">
                    Забронировать
                </button>
            </form>
        </article>
    </article>
</section>
@endsection
