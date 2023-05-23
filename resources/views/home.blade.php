@extends('adminlte::page')

@section('title', 'ホーム画面')

@section('content_header')
    <h1>ホーム画面</h1>
@stop

@section('content')
    <p>オレンジ、グレープ、チョコレート、バニラ味のアイスを扱っています</p>
    <div class="text-center mt-3">
        <img src="{{ asset('/images/home-aice.jpg') }}" alt="アイス商品画像">
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

