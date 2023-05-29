@extends('adminlte::page')

@section('title', '商品編集')

@section('content_header')
    <h1>商品編集画面</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 商品登録画面に遷移 --}}
            <div style="text-align: right;">
                <a href="{{ route('ItemCreate') }}" class="btn btn-primary">商品登録</a>
            </div>

            <div class="card card-primary">
                <form method="POST" action="{{ route('update', ['id' => $item['id']]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">商品名</label>
                            <input type="text" class="form-control" id="name" name="name" maxlength="100"
                                value="{{ $item['name'] }}">
                        </div>

                        <div class="form-group">
                            <label for="type" class="d-block">カテゴリー</label>
                            <select class="form-select" name="type">
                                <option value="1" {{ $item['type'] == 1 ? 'selected' : '' }}>オレンジ</option>
                                <option value="2" {{ $item['type'] == 2 ? 'selected' : '' }}>グレープ</option>
                                <option value="3" {{ $item['type'] == 3 ? 'selected' : '' }}>チョコレート</option>
                                <option value="4" {{ $item['type'] == 4 ? 'selected' : '' }}>バニラ</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <textarea name="detail" id="detail" name="detail" cols="30" rows="10" class="form-control"
                                maxlength="500">{{ $item['detail'] }}</textarea>
                        </div>

                        <!-- 画像アップロードフィールド -->
                        <div class="mb-3">
                            <label class="form-label d-block">現在の商品画像</label>
                            <img src="data:image/png;base64,{{ $item['image'] }}" alt="商品画像"
                                style="max-width:200px; max-heigth:200px;">
                            <input type="file" name="image" class="form-control" onchange="previewImage(this);">
                            <small class="form-text text-muted">画像ファイルのサイズは47KB以下にしてください。</small>

                            {{-- プレビュー表示エリア --}}
                            <label class="form-label d-block">更新する商品画像</label>
                            <img id="preview" src="" alt="商品画像"
                                style="max-width: 200px; max-height: 200px; display: none;">
                        </div>

                        <div class="form-group">
                            <label for="price">価格</label>
                            <input type="number" name="price" min="1" value="{{ $item['price'] }}"><span>円</span>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">更新</button>
                            {{-- 削除ボタン 削除機能 --}}
                            <button type="button" class="btn btn-primary"
                                onclick="location.href='{{ route('delete', ['id' => $item['id']]) }}'">削除</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    {{-- 画像プレビューのjavascript --}}
    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>
@stop
