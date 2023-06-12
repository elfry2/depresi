@extends('layouts.diagnosis')
@section('content')
<center>
<h2>Tenang saja.</h2>
<p class="mt-4">Masukan anda hanya disimpan selama sesi {{ strtolower($title) }} berlangsung dan dihapus secara permanen pada akhir sesi atau kapanpun anda menginginkannya. Kami tidak akan menanyakan informasi apapun yang dapat digunakan untuk mengidentifikasi anda.</p>
<p>Lima atau lebih simtom berikut ini harus muncul selama periode dua minggu terakhir dan mengakibatkan perubahan dari fungsi sebelumnya; setidaknya simtom-simtom tersebut termasuk (1) suasana hati depresif, (2) kehilangan minat atau kesenangan.</p>
</center>
@endsection
@section('actions')
<a href="/{{ $resource }}/create" class="w-100"><button class="btn btn-outline-success rounded-0 border-0 w-100" style="min-height: 3em">Mulai sesi</button></a>
@endsection
