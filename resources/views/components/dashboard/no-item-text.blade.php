<div class="d-flex h-100 justify-content-center align-items-center">
    <h5 class="text-center text-secondary">Belum ada {{ request('q') ?  strtolower($title) . " \"" .  request('q') . "\"" :  strtolower($title) }}. Klik <i
        class="bi-plus-lg"></i> <span class="hide-on-small-screens">Tambah</span> untuk menambahkan.</h5>
</div>