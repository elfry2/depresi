@extends('layouts.diagnosis')
@section('content')
<center>
<h2>Halo!</h2>
<p class="mt-4">Pada aplikasi ini, seluruh jawaban yang anda berikan akan disimpan selama sesi skrining dan dihapus secara permanen setelah sesi berakhir atau kapanpun anda menginginkannya. Kami tidak akan menanyakan informasi apapun yang dapat digunakan untuk mengidentifikasi anda.</p>
<p>Anda akan diberikan {{ $item }} butir pernyataan seputar kondisi anda selama <b>dua minggu terakhir</b>. Berikanlah jawaban yang sebenarnya agar hasil skrining sesuai dengan kondisi anda.</p>
</center>
@endsection
@section('actions')
<a href="/{{ $resource }}/create" class="w-100"><button class="btn btn-outline-success rounded-0 border-0 w-100" style="min-height: 3em">Mulai sesi</button></a>
@endsection
