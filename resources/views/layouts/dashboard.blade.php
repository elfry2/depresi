<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title . ' | ' . config('app.name') : config('app.name') }}</title>
    <link href="/css/bootstrap-5.3.0-alpha1-dist/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link href="/icons/bootstrap-icons-1.10.3/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    @laravelPWA
</head>

<body>
    {{-- @include('components.cover') --}}
    @include('components.dashboard.navbar')
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-lg-2 h-100" id="sidenavColumn">
                @include('components.dashboard.sidenav')
            </div>
            <div class="col-lg">
                @include('components.dashboard.search-query-text')
                @include('components.dashboard.alert')
                @yield('content')
                @include('components.dashboard.footer')
            </div>
        </div>
    </div>
    <script src="/js/bootstrap-5.3.0-alpha1-dist/bootstrap.bundle.min.js"></script>
</body>
</html>
