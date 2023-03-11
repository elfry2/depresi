@extends('layouts.diagnosis')
@section('content')
<h2 class="text-center">Tenang saja.</h2>
<p class="text-center mt-4">Masukan anda hanya disimpan selama sesi {{ strtolower($title) }} berlangsung dan dihapus secara permanen pada akhir sesi atau kapanpun anda menginginkannya. Kami tidak akan menanyakan informasi apapun yang dapat digunakan untuk mengidentifikasi anda.</p>
@endsection
@section('actions')
<a href="/{{ $resource }}/create" class="w-100"><button class="btn btn-outline-success rounded-0 border-0 w-100" style="min-height: 3em">Mulai sesi</button></a>
@endsection
