@extends('layouts.diagnosis')
@section('content')
    <h2 class="text-center">{{ $item->name }}</h2>
@endsection
@section('actions')
<form method="post" action="/{{ $resource }}" class="d-flex justify-content-center align-items-center">
    @csrf
    <input type="hidden" name="id" value="{{ $item->id }}">
    <div class="btn-group w-100" role="group" aria-label="Basic example" style="min-height: 3em">
        @foreach ($items2 as $item2)
            <button type="submit" name="frequency_id" value="{{ $item2->id }}"
            class="btn btn-outline-success rounded-0 border-0 w-50">{{ $item2->name }}</button>
        @endforeach
    </div>
</form>
@endsection