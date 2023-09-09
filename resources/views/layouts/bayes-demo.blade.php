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
</head>
<body>
    <div class="container h-100" style="max-width: 800px">
        <div class="row h-100">
            <div class="col-lg">
                <div class="d-flex flex-column h-100 mt-4">
                    <div class="card bg-white shadow-sm mt-2 w-100" style="">
                        <div class="card-body py-5">
                            @yield('content')
                        </div>
                        <div class="card-footer bg-white p-0">
                            @yield('actions')
                        </div>
                    </div>
                    @include('components.debug-card')
                </div>
            </div>
        </div>
    </div>
    <script src="/js/bootstrap-5.3.0-alpha1-dist/bootstrap.bundle.min.js"></script>
</body>
</html>
