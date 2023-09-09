@extends('layouts.bayes-demo')
@section('content')
    <h5>Evidences</h5>
    <ul>
        @foreach ($evidences as $evidence)
            <li>{{ $evidence->name }}</li>
        @endforeach
    </ul>
    <h5 class="mt-5">Hypothesis</h5>
    <span>{{ $hypothesis->name }}</span>
    <h5 class="mt-5">Probability</h5>
    <span>{{ $probability }}</span>
@endsection
@section('actions')
    <a class="btn" href="{{ route('bayes-demo.index') }}"><i class="bi-chevron-left"></i> Back</a>
@endsection
