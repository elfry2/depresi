@if (isset($debug))
<div class="card mt-4 shadow-sm w-100">
    <div class="card-header">
        <span class="h5">Debug</span>
    </div>
    <div class="card-body p-0">
        <div class="accordion accordion-flush" id="debugAccordionFlush">
            @foreach ($debug as $key => $value)
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-heading{{ $loop->iteration }}">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $loop->iteration }}" aria-expanded="false" aria-controls="flush-collapse{{ $loop->iteration }}">
                    {{ $key }}
                </button>
                </h2>
                <div id="flush-collapse{{ $loop->iteration }}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{ $loop->iteration }}" data-bs-parent="#debugAccordionFlush">
                <div class="accordion-body">
                    <pre>{{ print_r($value) }}</pre>
                </div>
                </div>
            </div>
            @endforeach
    </div>
</div>
@endif