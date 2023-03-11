<a data-bs-target="#sortingDirectionSelectionModal" data-bs-toggle="modal" class="btn btn-outline-dark border-0 me-1" href="#"
    title="Urutkan dari..."><i class="bi-sort-down"></i></a>
    <div id="sortingDirectionSelectionModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Urutkan dari...</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <ul class="list-group list-group-flush">
                        <a class="text-decoration-none" href="/preferences/{{ $resource }}SortingDirection/asc"><li class="list-group-item list-group-item-action py-3 @if ($preferences['sortingDirection'] === 'asc') bg-body-secondary @endif">Kecil-ke-besar</li></a>
                        <a class="text-decoration-none" href="/preferences/{{ $resource }}SortingDirection/desc"><li class="list-group-item list-group-item-action py-3 @if ($preferences['sortingDirection'] === 'desc') bg-body-secondary @endif">Besar-ke-kecil</li></a>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark border-0" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>