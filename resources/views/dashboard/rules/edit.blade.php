@extends('layouts.dashboard')
@section('actions')
    <a href="#" onclick="document.getElementById('ruleModificationForm').submit()" class="hide-on-small-screens btn btn-outline-dark border-0 me-1"
        title="{{ $title }}"><i class="bi-pencil-square"></i> Sunting</a>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="/{{ $resource }}/{{ $theItem->id }}" method="post" id="ruleModificationForm">
                @method('patch')
                @csrf
                <div class="row">
                    <div class="col">
                        <h5>Gejala yang dibutuhkan</h5>
                        @if ($items->count() <= 0)
                            <p class="text-muted">Belum ada gejala. Klik pada menu Gejala untuk menambahkan.</p>
                        @else
                            <table class="table table-striped table-hover bg-white border">
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td><input name="antecedent_ids[]" value="{{ $item->id }}"
                                                    id="inputSymptom{{ $item->id }}CheckboxInput" type="checkbox"
                                                    class="form-check-input" @if (in_array($item->id, $theItem->antecedent_ids)) checked @endif></td>
                                            <td><label for="inputSymptom{{ $item->id }}CheckboxInput"
                                                    class="form-check-label">{{ $item->name }}</label></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                                                    class="form-check-input" @if (isset($theItem->consequent_symptom_ids) && in_array($item->id, $theItem->consequent_symptom_ids)) checked @endif></td>
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
                                                    class="form-check-input"  @if ($theItem->consequent_disease_id == $item2->id) checked @endif></td>
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