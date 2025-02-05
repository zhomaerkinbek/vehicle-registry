@extends('layouts.app')

@section('title', 'История владельцев')

@section('content')
<h2>История владельцев авто</h2>
<form method="GET">
    <div class="mb-3">
        <label class="form-label">Номер авто</label>
        <input type="text" name="vehicle_number" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-info">Показать историю</button>
</form>

@if(isset($history))
    <h3 class="mt-4">История:</h3>
    <ul class="list-group">
        @foreach($history as $record)
            <li class="list-group-item">
                <strong>{{ $record->owner_name }}</strong> ({{ $record->registered_at_formatted }} - @if(isset($record->transferred_at_formatted)){{$record->transferred_at_formatted}} @else по настоящее время@endif)
            </li>
        @endforeach
    </ul>
@else
    <h3 class="mt-4">Нет результатов</h3>
@endif
@endsection