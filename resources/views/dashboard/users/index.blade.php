@extends('layouts.dashboard')
@section('actions')
    <a href="/register" class="btn btn-outline-dark border-0 me-1 hide-on-small-screens" title="Tambah {{ strtolower($title) }}"><i
            class="bi-plus-lg"></i> <span class="hide-on-small-screens">Tambah</span></a>
    <a href="/register">
        <div class="d-flex justify-content-center align-items-center hide-on-big-screens btn bg-white border shadow text-dark"
            style="width: 4em; height: 4em; border-radius: 50%; position: fixed; bottom: 1em; right: 1em; z-index: 1">
            <span class="h3 m-0"><i class="bi-plus-lg"></i></span>
        </div>
    </a>
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
                        <a class="text-decoration-none" href="/preferences/{{ $resource }}Sorting/role_id">
                            <li
                                class="list-group-item list-group-item-action py-3 @if ($preferences['sorting'] === 'role_id') bg-body-secondary @endif">
                                Jabatan</li>
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
        <div class="row">
            @foreach ($items as $item)
                <div class="col-lg-6">
                    <div class="card mb-4 overflow-auto m-0">
                        <div class="d-flex">
                            <div class="flex-grow-1 d-flex">
                                <div class="bg-body-secondary" style="height: 200px; width: 200px">
                                    <img style="height: 200px; width: 200px; object-fit: cover; object-position: top"
                                    src="{{ $item->path_to_photo ? asset('storage/' . $item->path_to_photo) : 'https://picsum.photos/200?' . rand() }}"
                                    class="rounded-start flex-shrink-0" alt="...">
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-0">{{ $item->name }}</h5>
                                    <small class="text-muted fw-light">{{ $item->email }}</small>
                                    <p class="card-text flex-grow-1 text-muted mt-1">{{ $item->role->name }}</p>
                                </div>
                            </div>
                            <div class="dropstart">
                                <button type="button" class="btn btn-outline-dark border-0 mt-2 me-2"
                                    data-bs-toggle="dropdown">
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
                                            data-bs-toggle="modal"
                                            class="dropdown-item @if ($item->id === Auth::id()) disabled @endif"
                                            type="button"><i class="bi-trash me-2"></i>Hapus</a>
                                    </li>
                                </ul>
                            </div>
                            <div id="item{{ $item->id }}ModificationModal" class="modal fade" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5">Sunting {{ strtolower($title) }}
                                                "{{ $item->name }}"</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="post" action="/{{ $resource }}/{{ $item->id }}">
                                            @csrf
                                            @method('patch')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="item{{ $item->id }}NameTextInput"
                                                        class="form-label">Nama</label>
                                                    <input name="name" id="item{{ $item->id }}NameTextInput"
                                                        type="text" class="form-control" value="{{ $item->name }}"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="item{{ $item->id }}EmailEmailInput"
                                                        class="form-label">Email</label>
                                                    <input name="email" id="item{{ $item->id }}EmailEmailInput"
                                                        type="email" class="form-control" value="{{ $item->email }}"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="item{{ $item->id }}RoleSelectInput"
                                                        class="form-label">Jabatan</label>
                                                    <select name="role_id" id="item{{ $item->id }}RoleSelectInput"
                                                        class="form-select">
                                                        @foreach ($items2 as $item2)
                                                            <option value="{{ $item2->id }}" @if ($item->role_id == $item2->id) selected @endif>{{ $item2->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- <div class="mb-3">
                                                    <label for="item{{ $item->id }}EmailEmailInput"
                                                        class="form-label">Email</label>
                                                    <input name="email" id="item{{ $item->id }}EmailEmailInput"
                                                        type="email" class="form-control" value="{{ $item->email }}"
                                                        required>
                                                </div> --}}
                                                <div class="mb-3">
                                                    <label for="item{{ $item->id }}PasswordPasswordInput"
                                                        class="form-label">Kata sandi <a class="text-decoration-none"
                                                            href="#"
                                                            onclick="toggleItem{{ $item->id }}PasswordPasswordInputVisibility(this)">Lihat</a></label>
                                                    <input name="password"
                                                        id="item{{ $item->id }}PasswordPasswordInput" type="password"
                                                        class="form-control" value="{{ old('password') }}"
                                                        placeholder="Kosongkan jika tidak ingin menyunting kata sandi">
                                                    <script>
                                                        function toggleItem{{ $item->id }}PasswordPasswordInputVisibility(toggle) {
                                                            input = document.getElementById('item{{ $item->id }}PasswordPasswordInput');

                                                            if (input.type === 'password') {
                                                                input.type = 'text';
                                                                toggle.innerHTML = 'Sembunyikan';
                                                            } else {
                                                                input.type = 'password';
                                                                toggle.innerHTML = 'Lihat';
                                                            }
                                                        }
                                                    </script>
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
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
