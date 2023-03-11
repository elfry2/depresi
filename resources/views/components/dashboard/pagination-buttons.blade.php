@if ((!isset($noPagination) || !$noPagination) && $items->count() > 0)
    <a class="btn btn-outline-dark border-0 me-1 @if ($items->onFirstPage()) disabled @endif"
        href="{{ $items->previousPageUrl() }}@if(request('q'))&q={{ request('q') }}@endif" title="Halaman sebelumnya"><i
            class="bi-chevron-left"></i></a>
    <a  data-bs-target="#pageJumpingModal" data-bs-toggle="modal" href="#" class="btn btn-outline-dark border-0 me-1" title="Loncat ke halaman...">{{ request('page') ?? 1 }}</a>
    <a class="btn btn-outline-dark border-0 me-1 @if (!$items->hasMorePages()) disabled @endif"
        href="{{ $items->nextPageUrl() }}@if(request('q'))&q={{ request('q') }}@endif" title="Halaman berikutnya"><i
            class="bi-chevron-right"></i></a>
    <div id="pageJumpingModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Loncat ke halaman...</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input name="page" id="pageNumberInput" type="number" class="form-control"
                                min="1" max="{{ $items->lastPage() }}" value="{{ $items->currentPage() }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-dark border-0" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-dark"><i class="bi-send"></i> Loncat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('pageJumpingModal')
            .addEventListener('shown.bs.modal', function() {
                document.getElementById('pageNumberInput').focus()
            });
    </script>
@endif
