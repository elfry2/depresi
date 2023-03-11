@extends('layouts.diagnosis')
@section('content')
    <h2 class="text-center">Apakah anda merasakan {{ strtolower($item->name) }}?</h2>
@endsection
@section('actions')
<form method="post" action="/{{ $resource }}" class="d-flex justify-content-center align-items-center">
    @csrf
    <input type="hidden" name="id" value="{{ $item->id }}">
    <div class="btn-group w-100" role="group" aria-label="Basic example" style="min-height: 3em">
        <button type="submit" name="isPresent" value="0"
            class="btn btn-outline-success rounded-0 border-0 w-50">Tidak</button>
        <button type="submit" name="isPresent" value="1"
            class="btn btn-outline-success rounded-0 border-0 border-start w-50">Ya</button>
    </div>
</form>
@endsection