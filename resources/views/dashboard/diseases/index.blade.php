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
                            <label for="nameTextInput" class="form-label">Nama</label>
                            <input name="name" id="nameTextInput" type="text" class="form-control"
                                value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="probabilityNumberInput" class="form-label">Probabilitas</label>
                            <input name="probability" id="probabilityNumberInput" type="number" class="form-control"
                                min="0" max="1" step="0.00001" value="{{ old('probability', 0) }}" required>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_healthy" value="1" id="isHealthyCheckboxInput">
                            <label class="form-check-label" for="isHealthyCheckboxInput">
                                Menandakan kondisi sehat
                            </label>
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
                document.getElementById('nameTextInput').focus()
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
                            <a class="text-decoration-none" href="/preferences/{{ $resource }}Sorting/name">
                                <li
                                    class="list-group-item list-group-item-action py-3 @if ($preferences['sorting'] === 'name') bg-body-secondary @endif">
                                    Nama</li>
                            </a>
                            <a class="text-decoration-none" href="/preferences/{{ $resource }}Sorting/probability">
                                <li
                                    class="list-group-item list-group-item-action py-3 @if ($preferences['sorting'] === 'probability') bg-body-secondary @endif">
                                    Probabilitas</li>
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
                    <th>Nama</th>
                    <th>Probabilitas <span class="fw-light hide-on-small-screens">(tanpa memandang gejala apapun)</span>
                    </th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration + (request('page') ? request('page') - 1 : 0) * config('app.itemsPerPage') }}
                            </td>
                            <td>{{ $item->id }}</td>
                            <td class="{{ $item->is_healthy ? 'text-success' : '' }}">{{ $item->name }}</td>
                            <td>{{ $item->probability }}</td>
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

                            <div id="item{{ $item->id }}ModificationModal" class="modal fade" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Sunting
                                                {{ strtolower($title) }} "{{ $item->name }}"</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="/{{ $resource }}/{{ $item->id }}" method="post">
                                            @method('patch')
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="nameTextInput" class="form-label">Nama</label>
                                                    <input name="name" id="item{{ $item->id }}NameTextInput"
                                                        type="text" class="form-control" value="{{ $item->name }}"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="probabilityNumberInput"
                                                        class="form-label">Probabilitas</label>
                                                    <input name="probability" id="probabilityNumberInput" type="number"
                                                        class="form-control" min="0" max="1"
                                                        step="0.00001" value="{{ $item->probability ?? 0 }}" required>
                                                </div>
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" name="is_healthy" value="1" id="item{{ $item->id }}IsHealthyCheckboxInput" {{  $item->is_healthy ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="item{{ $item->id }}IsHealthyCheckboxInput">
                                                        Menandakan kondisi sehat
                                                    </label>
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
                                                {{ strtolower($title) }} "{{ $item->name }}"?</h1>
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
