@extends('layouts.app')

@section('content')
<h2 class="mb-4 fw-bold"">Панель администратора</h2>

<article class="card border-0 shadow rounded-4 overflow-hidden">
    <article class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">Клиент</th>
                    <th>Услуга / Дата</th>
                    <th>Статус</th>
                    <th class="pe-4 text-end">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $app)
                <tr>
                    <td class="ps-4">
                        <article class="fw-bold">{{ $app->user->name }}</article>
                        <article class="small text-muted">{{ $app->user->phone }} / {{ $app->user->login }}</article>
                    </td>
                    <td>
                        <article class="fw-bold">{{ $app->service->name }}</article>
                        <article class="small text-muted">{{ $app->date }} в {{ $app->time }}</article>
                        <article class="small text-muted">Гостей: {{ $app->guests }}</article>
                    </td>
                    <td>
                        <span class="badge rounded-pill px-3 py-2
                            @if($app->status == 'Новая') bg-primary
                            @elseif($app->status == 'В работе' || $app->status == 'Посещение состоялось') bg-success
                            @else bg-danger @endif">
                            {{ $app->status }}
                        </span>
                    </td>
                    <td class="pe-4 text-end">
                        <form action="{{ route('admin.applications.status', $app) }}" method="POST" class="d-inline-flex gap-2">
                            @csrf
                            @method('PATCH')

                            <select name="status" class="form-select form-select-sm" style="width: 150px;" onchange="this.form.elements['cancel_reason'].style.display = (this.value == 'Отменена' ? 'block' : 'none')">
                                <option value="Новая" @selected($app->status == 'Новая')>Новая</option>
                                <option value="В работе" @selected($app->status == 'В работе')>В работе</option>
                                <option value="Посещение состоялось" @selected($app->status == 'Посещение состоялось')>Посещение состоялось</option>
                                <option value="Отменена" @selected($app->status == 'Отменена')>Отменена</option>
                            </select>

                            <input type="text" name="cancel_reason" class="form-control form-control-sm" placeholder="Причина отмены" style="display: {{ $app->status == 'Отменена' ? 'block' : 'none' }}; width: 200px;" value="{{ $app->cancel_reason }}">

                            <button type="submit" class="btn btn-sm btn-success px-3">OK</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </article>
</article>

@if($applications->isEmpty())
    <article class="text-center py-5">
        <p class="text-muted">Заявок пока нет</p>
    </article>
@endif

@endsection
