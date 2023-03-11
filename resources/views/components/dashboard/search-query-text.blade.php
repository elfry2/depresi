@if (request('q'))
    <p>Ditemukan {{ $items->count() ?? 0 }} hasil untuk <b>"{{ request('q') }}"</b>. <a class="text-decoration-none" href="/{{ $resource }}">Kosongkan</a></p>
@endif