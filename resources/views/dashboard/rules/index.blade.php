@extends('layouts.dashboard')
@section('actions')
<a class="hide-on-small-screens btn btn-outline-dark border-0 me-1"  href="/{{ $resource }}/create"
        title="Tambah {{ strtolower($title) }}"><i class="bi-plus-lg"></i>Tambah</a>
<a href="/{{ $resource }}/create">
    <div class="d-flex justify-content-center align-items-center hide-on-big-screens btn bg-white border shadow text-dark" style="width: 4em; height: 4em; border-radius: 50%; position: fixed; bottom: 1em; right: 1em; z-index: 1">
        <span class="h3 m-0"><i class="bi-plus-lg"></i></span>
    </div>
</a>
    @if ($items->count() > 0)
    @include('components.dashboard.sorting-direction-button')
    @endif
@endsection
@section('content')
    @if ($items->count() <= 0)
        @include('components.dashboard.no-item-text')
    @else
        <div class="table-responsive rounded border border-bottom-0">
            <table class="table table-striped table-hover bg-white m-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Id.</th>
                        <th>Kondisi yang dibutuhkan</th>
                        <th>Gejala yang dibangkitkan</th>
                        <th>Gangguan yang dibangkitkan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration + (request('page') ? request('page') - 1 : 0) * config('app.itemsPerPage') }}</td>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->antecedent_symptoms }}</td>
                            <td>{{ $item->consequent_symptoms }}</td>
                            <td>@if($item->consequent_disease) {{ $item->consequent_disease->disease->name }} @endif</td>
                            <td align="right">
                                <div class="dropstart">
                                    <button type="button" class="btn btn-outline-dark border-0" data-bs-toggle="dropdown">
                                        <i class="bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ $resource }}/{{ $item->id }}/edit" class="dropdown-item" type="button"><i
                                                    class="bi-pencil-square me-2"></i>Sunting</a></li>
                                        <li>
                                        <li><a href="#" data-bs-target="#item{{ $item->id }}IdModificationModal"
                                            data-bs-toggle="modal" class="dropdown-item" type="button"><i
                                                    class="bi-key me-2"></i>Ganti Id. ke...</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a href="#" data-bs-target="#item{{ $item->id }}DeletionModal"
                                                data-bs-toggle="modal" class="dropdown-item" type="button"><i
                                                    class="bi-trash me-2"></i>Hapus</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <div id="item{{ $item->id }}IdModificationModal" class="modal fade" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Ganti Id. {{ strtolower($title) }} {{ $item->id }} ke...</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="/{{ $resource }}/{{ $item->id }}" method="post">
                                            @csrf
                                            @method('patch')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <input type="hidden" name="method" value="changeId">
                                                    <input name="id" type="number" class="form-control"
                                                        min="{{ $items->first()->id }}" max="{{ $items->last()->id }}" value="{{ $item->id }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-dark border-0" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-dark"><i class="bi-key"></i> Ganti</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="item{{ $item->id }}DeletionModal" class="modal fade" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Hapus
                                                {{ strtolower($title) }} {{ $item->id }}?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{ $title }} yang dihapus tidak dapat dikembalikan.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-dark border-0"
                                                data-bs-dismiss="modal">Batal</button>
                                            <form action="/{{ $resource }}/{{ $item->id }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger"><i class="bi-trash"></i>
                                                    Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
