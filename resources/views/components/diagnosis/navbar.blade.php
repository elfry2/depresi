<div class="flex-grow-1"><a href="/" class="align-self-start btn btn-outline-success border-0"><i
    class="bi-chevron-left"></i> Kembali</a></div>
@auth
<a href="/dashboard" class="align-self-start btn btn-outline-success border-0"><i
class="bi-menu-button-wide-fill"></i> Dasbor</a>
@endauth
<a data-bs-toggle="modal" data-bs-target="#itemDeletionModal" href="#"
class="justify-self-start align-self-start btn btn-outline-success border-0"><i
class="bi-file-earmark-plus"></i> Mulai sesi baru</a>
<div class="modal fade" id="itemDeletionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mulai sesi {{ strtolower($title) }} baru?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Data dari sesi ini akan dihapus.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Batal</button>
                <a href="/{{ $resource }}?purgeWorkspace=1" type="button" class="btn btn-danger">Ya, hapus
                    data dan mulai sesi baru</a>
            </div>
        </div>
    </div>
</div>
@if (Request::is('diagnosis/result'))
<a href="#" onclick="window.print()" class="btn btn-outline-success border-0"><i class="bi-printer"></i> Cetak</a>
@endif