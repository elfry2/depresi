@foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $error }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endforeach
@if (session('message'))
    <div class="alert alert-{{ session('message')->type }} alert-dismissible fade show" role="alert">
        {{ session('message')->content }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif