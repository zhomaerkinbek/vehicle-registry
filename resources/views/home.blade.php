@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="row">
    <div class="col-md-6">
        <h2>Регистрация авто</h2>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">ФИО владельца</label>
                <input type="text" name="owner_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Марка</label>
                <input type="text" name="brand" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Модель</label>
                <input type="text" name="model" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Зарегистрировать</button>
        </form>
    </div>

    <div class="col-md-6">
        <h2>Перерегистрация авто</h2>
        <form action="{{ route('reRegister') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Номер авто</label>
                <input type="text" name="vehicle_number" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">ФИО нового владельца</label>
                <input type="text" name="new_owner_name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-warning">Перерегистрировать</button>
        </form>
    </div>
</div>
@endsection