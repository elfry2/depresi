@if ($items->count() > 0)
<form action="/{{ $resource }}" class="d-flex position-absolute translate-middle-x start-50 hide-on-small-screens flex-shrink-0" role="search">
    <div class="input-group">
        <input class="form-control border border-end-0" type="search" name="q" id="searchTextInput"
            placeholder="Tekan '/' untuk mencari..." value="{{ request('q') }}">
        <button class="btn btn-outline-dark border border-start-0" type="submit"><i class="bi-search"></i></button>
    </div>
</form>
<script>
    window.addEventListener('keyup', function(event) {
        if (event.key === '/') document.getElementById('searchTextInput').focus();
    });
</script>
@endif
