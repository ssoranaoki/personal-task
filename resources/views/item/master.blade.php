@extends('adminlte::page')

@section('title', '管理者画面')

@section('content_header')
    <h1>管理者画面</h1>
    {{-- 絞り込み検索 --}}
    <h6 class="mt-3">検索したい商品の情報を入力して下さい</h6>
    <div>
        <form method="GET" action="{{ route('ItemSearch') }}" class="d-block">
            <select name="category" class="col-4">
                <option value="" hidden>カテゴリーを選択してください</option>
                <option value="1">オレンジ</option>
                <option value="2">グレープ</option>
                <option value="3">チョコレート</option>
                <option value="4">バニラ</option>
            </select>
            <div class="form-group col-6">
                <input type="text" maxlength="20" name="keyword" class="form-control" value=""
                    placeholder="キーワードを入力してください（20文字以内）">
            </div>
            <div class="form-group">
                <input type="submit" value="検索" class="btn btn-info" style="margin-left: 15px; color:white;">
            </div>
        </form>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">商品一覧</h3>
                        {{-- アラートメッセージ --}}
                        @if (session('RegisterMessage') || session('UpdateMessage') || session('DeleteMessage'))
                            <div class="alert alert-success">
                                @if (session('RegisterMessage'))
                                    {{ session('RegisterMessage') }}
                                @elseif (session('UpdateMessage'))
                                    {{ session('UpdateMessage') }}
                                @elseif (session('DeleteMessage'))
                                    {{ session('DeleteMessage') }}
                                @endif
                            </div>
                        @endif
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
            </div>
            {{-- ページネーション --}}
            {{ $items->links('pagination::bootstrap-4') }}
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
