@extends('adminlte::page')

@section('title', '管理者画面')

@section('content_header')
    <h1>管理者画面</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">商品一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ route('ItemCreate') }}" class="btn btn-default">商品登録</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>商品名</th>
                                <th>カテゴリー</th>
                                <th>価格</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @switch($item->type)
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
                                    <td>{{ number_format($item->price) }}円</td>
                                    <td>
                                        <button type="button" class="btn btn-primary"
                                            onclick="location.href='{{ route('edit', ['id' => $item['id']]) }}'">編集</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $items->links() }}
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
