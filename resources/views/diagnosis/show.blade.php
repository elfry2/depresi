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
    <div class="container h-100" style="max-width: 1024px">
        <div class="row h-100">
            <div class="col-lg">
                <div class="d-flex flex-column h-100 mt-4">
                    <div class="d-flex w-100 hide-on-print">
                        @include('components.diagnosis.navbar')
                    </div>
                    <div class="card bg-white shadow-sm mt-2 w-100" style="">
                        <div class="card-body py-5">
                            <center>
                                <p>Dari hasil skrining yang dilakukan, dinyatakan bahwa anda @if ($item->isFound)
                                    memiliki kecenderungan
                                @endif</p>
                                <h1 class="mb-0 pb-0">{{ $item->name }}</h1>
                                @if ($item->isFound)
                                    <p class="m-0 p-0 fw-light text-center">Probabilitas: {{ $item->bayes }}</p>
                                    <p class="mt-3 text-center">Disarankan anda segera menemui profesional di bidang kesehatan jiwa (dokter spesialis kesehatan jiwa dan psikolog)</p>
                                @endif
                            </center>
                            @if ($item->isFound)
                                <div class="row mt-5">
                                    <div class="col-lg">
                                        <h5>Gejala-gejala gangguan:</h5>
                                        <ul>
                                            @foreach ($item->antecedents as $symptom)
                                                <li>{{ $symptom }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-lg">
                                        <h5>Gejala-gejala yang ditemukan:</h5>
                                        <ul>
                                            @foreach ($item->presentSymptoms as $symptom)
                                                <li>{{ $symptom }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-white p-0">
                            @yield('actions')
                        </div>
                    </div>
                    <div class="hide-on-print">
                        <h3 class="mt-5 text-center">Konsultasi dengan pakar kami!</h3>
                    @if ($items2->count() <= 0)
                        @include('components.dashboard.no-item-text')
                    @else
                        <div class="row mt-5">
                            @foreach ($items2 as $item)
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
                                                                <a href="tel:+{{ $item->phone_number }}"
                                                                    class="btn btn-dark"><i
                                                                        class="bi-telephone me-2"></i>+{{ $item->phone_number }}</a>
                                                            @endif
                                                            @if (!empty($item->phone_number) && $item->has_whatsapp)
                                                                <a href="https://wa.me/{{ $item->phone_number }}"
                                                                    target="_blank" class="btn btn-success"><i
                                                                        class="bi-whatsapp"></i></a>
                                                            @endif
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
                    </div>
                    @include('components.debug-card')
                </div>
            </div>
        </div>
    </div>
    <script src="/js/bootstrap-5.3.0-alpha1-dist/bootstrap.bundle.min.js"></script>
</body>

</html>
