@extends('layouts.app')

@section('title', 'Статистика моделей')

@section('content')
<h2>Статистика зарегистрированных моделей</h2>

@if(count($stats) > 0)
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Марка</th>
                <th>Модель</th>
                <th>Количество</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stats as $stat)
                <tr>
                    <td>{{ $stat->brand }}</td>
                    <td>{{ $stat->model }}</td>
                    <td>{{ $stat->count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="alert alert-warning">Нет зарегистрированных автомобилей.</div>
@endif
@endsection