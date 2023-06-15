@extends('layouts.dashboard')
@section('actions')
    @include('components.dashboard.creation-button')
    <div id="itemCreationModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Tambah {{ strtolower($title) }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="minimumScoreNumberInput" class="form-label">Skor minimal</label>
                            <input name="min" id="minimumScoreNumberInput" type="number" class="form-control"
                                min="0" step="1" value="{{ old('min') }}">
                        </div>
                        <div class="mb-3">
                            <label for="maximumScoreNumberInput" class="form-label">Skor maksimal</label>
                            <input name="max" id="maximumScoreNumberInput" type="number" class="form-control"
                                min="0" step="1" value="{{ old('max') }}">
                        </div>
                        <div class="mb-3">
                            <label for="diseaseSelectInput" class="form-label">Gangguan</label>
                            <select id="diseaseSelectInput" name="disease_id" class="form-select">
                                @foreach ($items2 as $item2)
                                    <option value="{{ $item2->id }}">{{ $item2->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark border-0" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-dark"><i class="bi-plus-lg"></i> Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('itemCreationModal')
            .addEventListener('shown.bs.modal', function() {
                document.getElementById('minimumScoreNumberInput').focus()
            });
    </script>
    @if ($items->count() > 0)
        <a data-bs-target="#sortingSelectionModal" data-bs-toggle="modal" class="btn btn-outline-dark border-0 me-1"
            href="#" title="Urutkan berdasarkan..."><i class="bi-sort-alpha-down"></i></a>
        <div id="sortingSelectionModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Urutkan berdasarkan...</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0">
                        <ul class="list-group list-group-flush">
                            <a class="text-decoration-none" href="/preferences/{{ $resource }}Sorting/id">
                                <li
                                    class="list-group-item list-group-item-action py-3 @if ($preferences['sorting'] === 'id') bg-body-secondary @endif">
                                    Id.</li>
                            </a>
                            <a class="text-decoration-none" href="/preferences/{{ $resource }}Sorting/min">
                                <li
                                    class="list-group-item list-group-item-action py-3 @if ($preferences['sorting'] === 'min') bg-body-secondary @endif">
                                    Skor minimal</li>
                            </a>
                            <a class="text-decoration-none" href="/preferences/{{ $resource }}Sorting/max">
                                <li
                                    class="list-group-item list-group-item-action py-3 @if ($preferences['sorting'] === 'max') bg-body-secondary @endif">
                                    Skor maksimal</li>
                            </a>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark border-0" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
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
                    <th>#</th>
                    <th>Id.</th>
                    <th>Skor minimal</th>
                    <th>Skor maksimal</th>
                    <th>Gangguan yang dibangkitkan</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration + (request('page') ? request('page') - 1 : 0) * config('app.itemsPerPage') }}
                            </td>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->min }}</td>
                            <td>{{ $item->max }}</td>
                            <td>{{ $item->disease->name }}</td>
                            <td align="right">
                                <div class="dropstart">
                                    <button type="button" class="btn btn-outline-dark border-0" data-bs-toggle="dropdown">
                                        <i class="bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" data-bs-target="#item{{ $item->id }}ModificationModal"
                                                data-bs-toggle="modal" class="dropdown-item" type="button"><i
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
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Ganti Id.
                                                {{ strtolower($title) }} {{ $item->id }} ke...</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="/{{ $resource }}/{{ $item->id }}" method="post">
                                            @csrf
                                            @method('patch')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <input type="hidden" name="method" value="changeId">
                                                    <input name="id" type="number" class="form-control"
                                                        min="{{ $items->first()->id }}" max="{{ $items->last()->id }}"
                                                        value="{{ $item->id }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-dark border-0"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-dark"><i class="bi-key"></i>
                                                    Ganti</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="item{{ $item->id }}ModificationModal" class="modal fade" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Sunting
                                                {{ strtolower($title) }} {{ $item->id }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="/{{ $resource }}/{{ $item->id }}" method="post">
                                            @method('patch')
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="item{{ $item->id }}MinimumScoreNumberInput"
                                                        class="form-label">Skor minimal</label>
                                                    <input name="min"
                                                        id="item{{ $item->id }}MinimumScoreNumberInput"
                                                        type="number" class="form-control" min="0"
                                                        step="1"
                                                        value="{{ $item->min }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="item{{ $item->id }}MaximumScoreNumberInput"
                                                        class="form-label">Skor maksimal</label>
                                                    <input name="max"
                                                        id="item{{ $item->id }}MaximumScoreNumberInput"
                                                        type="number" class="form-control" min="0"
                                                        step="1"
                                                        value="{{ $item->max }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="item{{ $item->id }}DiseaseSelectInput"
                                                        class="form-label">Gangguan</label>
                                                    <select id="item{{ $item->id }}DiseaseSelectInput"
                                                        name="disease_id" class="form-select">
                                                        @foreach ($items2 as $item2)
                                                            <option value="{{ $item2->id }}"
                                                                @if ($item->id == $item2->id) selected @endif>
                                                                {{ $item2->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-dark border-0"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-dark"><i
                                                        class="bi-pencil-square"></i> Sunting</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <script>
                                document.getElementById('item{{ $item->id }}ModificationModal')
                                    .addEventListener('shown.bs.modal', function() {
                                        document.getElementById('item{{ $item->id }}NameTextInput').focus()
                                    });
                            </script>
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
