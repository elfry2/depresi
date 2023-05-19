<ul class="mb-4 nav flex-column bg-white">
    <small class="fw-bold">Pengetahuan</small>
    <li class="nav-item mt-2">
        <a class="nav-link text-dark @if(request()->is('diseases*')) bg-body-secondary rounded @endif" href="/diseases"><i class="bi-virus2 me-2"></i>Gangguan</a>
    </li>
    <li class="nav-item mt-2">
        <a class="nav-link text-dark @if(request()->is('symptoms*')) bg-body-secondary rounded @endif" href="/symptoms"><i class="bi-file-earmark-medical me-2"></i>Gejala</a>
    </li>
    <li class="nav-item mt-2">
        <a class="nav-link text-dark @if(request()->is('rules*')) bg-body-secondary rounded @endif" href="/rules"><i class="bi-arrow-return-right me-2"></i>Aturan</a>
    </li>
    @if(Auth::user()->role_id == 1)
    <small class="mt-4 fw-bold">Mitra</small>
    <li class="nav-item mt-2">
        <a class="nav-link text-dark @if(request()->is('experts*')) bg-body-secondary rounded @endif" href="/experts"><i class="bi-person-check me-2"></i>Pakar</a>
    </li>
    <li class="nav-item mt-2">
        <a class="nav-link text-dark @if(request()->is('users*')) bg-body-secondary rounded @endif" href="/users"><i class="bi-person me-2"></i>Pengguna</a>
    </li>
    @endif
    <small class="mt-4 fw-bold">Publik</small>
    <li class="nav-item mt-2">
        <a class="nav-link text-dark" href="/"><i class="bi-house me-2"></i>Halaman awal</a>
    </li>
    <li class="nav-item mt-2">
        <a class="nav-link text-dark" href="/diagnosis/create"><i class="bi-file-earmark-medical me-2"></i>Skrining</a>
    </li>
    <small class="mt-4 fw-bold">{{ Auth::user()->name }}</small>
    <li class="nav-item mt-2">
        <a class="nav-link text-dark" href="/profile"><i class="bi-person me-2"></i>Profil</a>
    </li>
    <li class="nav-item mt-2">
        <form action="/logout" method="post">
        @csrf
        <button type="submit" class="nav-link text-dark border-0 bg-white" target="_blank" href=""><i class="bi-box-arrow-left me-2"></i>Keluar</button>
        </form>
    </li>
</ul>
<script>
    function toggleSidenav() {
            if (document.getElementById('sidenavColumn').style.display == 'none') {
                document.getElementById('sidenavColumn').style.display = 'block';
                localStorage.setItem('preferences.isSidenavHidden', false);
            }
            else {
                document.getElementById('sidenavColumn').style.display = 'none';
                localStorage.setItem('preferences.isSidenavHidden', true);
            }
        }

        if (localStorage.getItem('preferences.isSidenavHidden') == 'true'
        || window.innerWidth <= 960) {
            document.getElementById('sidenavColumn').style.display = 'none';
        }
</script>