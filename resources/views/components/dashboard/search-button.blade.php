@if ($items->count() > 0)
    <a data-bs-target="#searchFormModal" data-bs-toggle="modal"
        class="btn btn-outline-dark border-0 me-1 hide-on-big-screens" href="#" title="Cari..."><i
            class="bi-search"></i></a>
    <div id="searchFormModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <form role="search">
                        <div class="input-group">
                            <input class="form-control border border-end-0" type="search" name="q"
                                id="smallScreensSearchTextInput" placeholder="Cari..." value="{{ request('q') }}">
                            <button class="btn btn-outline-dark border border-start-0" type="submit"><i
                                    class="bi-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('searchFormModal')
            .addEventListener('shown.bs.modal', function() {
                document.getElementById('smallScreensSearchTextInput').focus()
            });
    </script>
@endif
