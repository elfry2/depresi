@extends('layouts.bayes-demo')
@section('content')
    <form action="{{ route('bayes-demo.result') }}" method="post">
        @csrf
        <h5>Evidences</h5>
        <div class="row">
            @foreach ($evidences as $evidence)
                <div class="col-sm-3">
                    <input type="checkbox" name="evidenceIds[]" value="{{ $evidence->id }}" id="evidenceCheckBoxInput{{ $evidence->id }}" class="form-check-input">
                    <label for="evidenceCheckBoxInput{{ $evidence->id }}" class="form-check-label">{{ $evidence->name }}</label>
                </div>
            @endforeach
        </div>
        <h5 class="mt-5">Hypothesis</h5>
        <select name="hypothesisId" class="form-select" aria-label="Default select example">
            @foreach ($hypotheses as $hypothesis)
                <option value="{{ $hypothesis->id }}">{{ $hypothesis->name }}</option>
            @endforeach
        </select>
        <div class="mt-5 d-flex flex-row-reverse">
            <button class="btn btn-success"><i class="bi-send"></i> Get probability</button>
        </div>
    </form>
@endsection
