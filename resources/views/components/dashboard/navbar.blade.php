<nav class="navbar navbar-expand py-3 overflow-x-auto">
    <div class="container-fluid">
        <a id="sidenavTogglerButton" onclick="toggleSidenav()" class="btn btn-outline-dark border-0 me-1" href="#"
            title="Tampilkan/sembunyikan sidebar"><i class="bi-list"></i></a>
        @include('components.dashboard.back-button')
        <a class="h1 m-0 me-2 navbar-brand hide-on-small-screens" href="#" onclick="document.getElementById('sidenavTogglerButton').click()">{{ config('app.name') }}</a>
        <a class="h1 m-0 me-2 navbar-brand hide-on-big-screens" href="#" onclick="document.getElementById('sidenavTogglerButton').click()">{{ $title ?? config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @include('components.dashboard.search-form')
            <div class="navbar-nav ms-auto">
                @include('components.dashboard.search-button')
                @yield('actions')
                @include('components.dashboard.pagination-buttons')
            </div>
        </div>
    </div>
</nav>
