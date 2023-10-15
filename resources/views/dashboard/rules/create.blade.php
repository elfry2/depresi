@extends('layouts.dashboard')
@section('actions')
    <a href="#" onclick="document.getElementById('ruleCreationForm').submit()" class="hide-on-small-screens btn btn-outline-dark border-0 me-1"
        title="{{ $title }}"><i class="bi-plus-lg"></i> Tambah</a>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="/{{ $resource }}" method="post" id="ruleCreationForm">
                @csrf
                <div class="row">
                    <div class="col">
                        <h5>Kondisi yang dibutuhkan</h5>
                        @if ($items->count() <= 0)
                            <p class="text-muted">Belum ada gejala. Klik pada menu Gejala untuk menambahkan.</p>
                        @else
                            <table class="table table-striped table-hover bg-white border">
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td><input name="antecedent_symptom_ids[]" value="{{ $item->id }}"
                                                    id="inputSymptom{{ $item->id }}CheckboxInput" type="checkbox"
                                                    class="form-check-input" @if (!is_null(old('antecedent_symptom_ids')) && in_array($item->id, old('antecedent_symptom_ids'))) checked @endif></td>
                                            <td><label for="inputSymptom{{ $item->id }}CheckboxInput"
                                                    class="form-check-label">{{ $item->name }}</label></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="card mt-2">
                                <div class="card-body">
                                    <div class="form-check">
                                        <label for="useSymptomPresenceCountCheckboxInput" class="form-check-label">Jumlah gejala yang muncul</label>
                                        <input type="checkbox" class="form-check-input" id="useSymptomPresenceCountCheckboxInput" name="use_symptom_presence_count" value="1">
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm">
                                            <div class="form-floating">
                                                <input id="symptomPresenceCountFromNumberInput" type="number" class="form-control" placeholder="">
                                                <label for="symptomPresenceCountFromNumberInput" class="form-label">Dari</label>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-floating">
                                                <input id="symptomPresenceCountToNumberInput" type="number" class="form-control" placeholder="">
                                                <label for="symptomPresenceCountToNumberInput" class="form-label">Hingga</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-2">
                                <div class="card-body">
                                    <div class="form-check">
                                        <label for="useSymptomPresenceFrequencyScoreCheckboxInput" class="form-check-label">Skor frekuensi kemunculan gejala</label>
                                        <input type="checkbox" class="form-check-input" id="useSymptomPresenceFrequencyScoreCheckboxInput" name="use_symptom_presence_frequency_score" value="1">
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm">
                                            <div class="form-floating">
                                                <input id="symptomPresenceFrequencyScoreFromNumberInput" type="number" class="form-control" placeholder="">
                                                <label for="symptomPresenceFrequencyScoreFromNumberInput" class="form-label">Dari</label>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <div class="form-floating">
                                                <input id="symptomPresenceFrequencyScoreToNumberInput" type="number" class="form-control" placeholder="">
                                                <label for="symptomPresenceFrequencyScoreToNumberInput" class="form-label">Hingga</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col">
                        <h5>Gejala yang dibangkitkan</h5>
                        @if ($items->count() <= 0)
                            <p class="text-muted">Belum ada gejala. Klik pada menu Gejala untuk menambahkan.</p>
                        @else
                            <table class="table table-striped table-hover bg-white border">
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td><input name="consequent_symptom_ids[]" value="{{ $item->id }}"
                                                    id="outputSymptom{{ $item->id }}CheckboxInput" type="checkbox"
                                                    class="form-check-input" @if (!is_null(old('consequent_symptom_ids')) && in_array($item->id, old('consequent_symptom_ids'))) checked @endif></td>
                                            <td><label for="outputSymptom{{ $item->id }}CheckboxInput"
                                                    class="form-check-label">{{ $item->name }}</label></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div class="col">
                        <h5>Gangguan yang dibangkitkan</h5>
                        @if ($items2->count() <= 0)
                            <p class="text-muted">Belum ada penyakit. Klik pada menu Gangguan untuk menambahkan.</p>
                        @else
                            <table class="table table-striped table-hover bg-white border">
                                <tbody>
                                    <tr>
                                        <td><input name="consequent_disease_id" value="" id="noConsequentDiseaseCheckboxInput"
                                                type="radio" class="form-check-input" checked></td>
                                        <td><label for="noConsequentDiseaseCheckboxInput" class="form-check-label">Tidak ada</label>
                                        </td>
                                    </tr>
                                    @foreach ($items2 as $item2)
                                        <tr>
                                            <td><input name="consequent_disease_id" value="{{ $item2->id }}"
                                                    id="consequentDisease{{ $item2->id }}CheckboxInput" type="radio"
                                                    class="form-check-input"  @if (old('consequent_disease_id') == $item2->id) checked @endif></td>
                                            <td><label for="consequentDisease{{ $item2->id }}CheckboxInput"
                                                    class="form-check-label">{{ $item2->name }}</label></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection