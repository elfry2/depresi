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
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nameTextInput" class="form-label">Nama</label>
                            <input name="name" id="nameTextInput" type="text" class="form-control"
                                value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="addressTextAreaInput"
                                class="form-label">Alamat</label>
                            <textarea name="address" id="addressTextAreaInput" class="form-control">{{ old('address') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="phoneNumberInput" class="form-label">No. telepon</label>
                            <input name="phone_number" id="phoneNumberInput" type="text" class="form-control"
                                value="{{ old('phone_number') }}" placeholder="Gunakan format internasional tanpa '+'">
                        </div>
                        <div class="mb-3">
                            <input name="has_whatsapp" id="hasWhatsAppCheckboxInput" type="checkbox"
                                class="form-check-input" @if (old('has_whatsapp')) checked @endif>
                            <label for="hasWhatsAppCheckboxInput" class="form-check-label">Terdaftar di WhatsApp</label>
                        </div>
                        <div class="mb-3">
                            <label for="photoFileInput" class="form-label">Foto</label>
                            <input name="photo" id="photoFileInput" type="file" class="form-control" accept="image/*">
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
    <a data-bs-target="#sortingSelectionModal" data-bs-toggle="modal" class="btn btn-outline-dark border-0 me-1" href="#"
    title="Urutkan berdasarkan..."><i class="bi-sort-alpha-down"></i></a>
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
                        <a class="text-decoration-none" href="/preferences/{{ $resource }}Sorting/address">
                            <li
                                class="list-group-item list-group-item-action py-3 @if ($preferences['sorting'] === 'address') bg-body-secondary @endif">
                                Alamat</li>
                        </a>
                        <a class="text-decoration-none" href="/preferences/{{ $resource }}Sorting/phone_number">
                            <li
                                class="list-group-item list-group-item-action py-3 @if ($preferences['sorting'] === 'phone_number') bg-body-secondary @endif">
                                No. telepon</li>
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
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <p class="card-text flex-grow-1">{{ $item->address }}</p>
                                    <div>
                                        <div class="btn-group">
                                            @if ($item->phone_number)
                                            <a href="tel:+{{ $item->phone_number }}" class="btn btn-dark"><i
                                                    class="bi-telephone me-2"></i>+{{ $item->phone_number }}</a>
                                        @endif
                                        @if (!empty($item->phone_number) && $item->has_whatsapp)
                                            <a href="https://wa.me/{{ $item->phone_number }}" target="_blank" class="btn btn-success"><i
                                                    class="bi-whatsapp"></i></a>
                                        @endif
                                        </div>
                                    </div>
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
                                            data-bs-toggle="modal" class="dropdown-item" type="button"><i
                                                class="bi-trash me-2"></i>Hapus</a>
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
                                        <form method="post" action="/{{ $resource }}/{{ $item->id }}"
                                            enctype="multipart/form-data">
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
                                                    <label for="item{{ $item->id }}AddressTextAreaInput"
                                                        class="form-label">Alamat</label>
                                                    <textarea name="address" id="item{{ $item->id }}AddressTextAreaInput" class="form-control">{{ $item->address }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="item{{ $item->id }}PhoneNumberInput"
                                                        class="form-label">No. telepon</label>
                                                    <input name="phone_number"
                                                        id="item{{ $item->id }}PhoneNumberInput" type="text"
                                                        class="form-control" value="{{ $item->phone_number }}"
                                                        placeholder="Gunakan format internasional tanpa '+'">
                                                </div>
                                                <div class="mb-3">
                                                    <input name="has_whatsapp"
                                                        id="item{{ $item->id }}HasWhatsAppCheckboxInput"
                                                        type="checkbox" class="form-check-input"
                                                        @if ($item->has_whatsapp) checked @endif>
                                                    <label for="item{{ $item->id }}HasWhatsAppCheckboxInput"
                                                        class="form-check-label">Terdaftar di WhatsApp</label>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="item{{ $item->id }}PhotoFileInput"
                                                        class="form-label">Foto</label>
                                                    <input name="photo" id="item{{ $item->id }}PhotoFileInput"
                                                        type="file" class="form-control" accept="image/*">
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
