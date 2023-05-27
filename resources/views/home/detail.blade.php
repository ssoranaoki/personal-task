@extends('adminlte::page')

@section('title', '商品詳細画面')

@section('content_header')
    <h1>商品詳細画面</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="form-group">
                    <label for="name" class="d-block">商品名</label>
                    <td>{{ $item['name'] }}</td>
                </div>
                <div class="form-group">
                    <label for="type" class="d-block">カテゴリー</label>
                    <td>
                        @switch($item['type'])
                            @case(1)
                                オレンジ
                            @break

                            @case(2)
                                グレープ
                            @break

                            @case(3)
                                チョコレート
                            @break

                            @case(4)
                                バニラ
                            @break
                        @endswitch
                    </td>
                </div>
                <div class="form-group">
                    <label for="detail" class="d-block">詳細</label>
                    <td>{{ $item['detail'] }}</td>
                </div>
                <div class="form-group">
                    <label for="price" class="d-block">価格</label>
                    <td>{{ $item['price'] }}</td><span>円</span>
                </div>
                <label for="">商品画像</label>
                <img src="data:image/png;base64,{{ $item['image'] }}" alt="商品画像" style="max-width:200px; max-height:200px;">
            </div>
        </div>
    @stop

    @section('css')
    @stop

    @section('js')
    @stop
