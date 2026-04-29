@extends('layouts.app')

@section('content')
<h2 class="mb-4">Панель администратора</h2>

<article class="card border-0 shadow-sm overflow-hidden">
    <article class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Клиент</th>
                    <th>Услуга / Адрес</th>
                    <th>Статус</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                <tr>
                    <td>#{{ $booking->id }}</td>
                    <td>
                        <strong>{{ $booking->user->name }}</strong><br>
                        <small class="text-muted">{{ $booking->user->phone }}</small>
                    </td>
                    <td>
                        {{ $booking->service->name }}<br>
                        <small class="text-muted">{{ $booking->address }}</small>
                    </td>
                    <td>
                        <span class="badge
                            @if($booking->status == 'Новая') bg-primary
                            @elseif($booking->status == 'В работе') bg-warning text-dark
                            @elseif($booking->status == 'Выполнена') bg-success
                            @else bg-danger @endif">
                            {{ $booking->status }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="d-flex gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="form-select form-select-sm" style="width: 130px;">
                                <option value="Новая" @selected($booking->status == 'Новая')>Новая</option>
                                <option value="В работе" @selected($booking->status == 'В работе')>В работе</option>
                                <option value="Выполнена" @selected($booking->status == 'Выполнена')>Выполнена</option>
                                <option value="Отменена" @selected($booking->status == 'Отменена')>Отменена</option>
                            </select>

                            <input type="text" name="cancel_reason" class="form-control form-control-sm" placeholder="Причина отмены" value="{{ $booking->cancel_reason }}">

                            <button class="btn btn-sm btn-dark">OK</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </article>
</article>
@endsection
