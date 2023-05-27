@extends('adminlte::page')

@section('title', 'ホーム画面')

@section('content_header')
    <h1>ホーム画面</h1>
    @if (session('LoginMessage'))
        <div class="alert alert-success">
            {{ session('LoginMessage') }}
        </div>
    @endif
@stop

@section('content')
    <p>オレンジ、グレープ、チョコレート、バニラ味のアイスを扱っています</p>
    <div class="text-center mt-3">
        <img src="{{ asset('/images/home-aice.jpg') }}" alt="アイス商品画像">
    </div>

    {{-- 管理者の場合、商品登録ボタンを表示 --}}
    @can('admin')
        <div class="text-center mt-3">
            <a href="{{ route('ItemCreate') }}" class="btn btn-default">商品登録</a>
        </div>
    @endcan
    @stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
