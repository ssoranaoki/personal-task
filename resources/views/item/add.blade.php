@extends('adminlte::page')

@section('title', '商品登録')

@section('content_header')
    <h1>商品登録</h1>
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

            <div class="card card-primary">
                <form method="POST" action="{{ route('ItemRegister') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">商品名</label>
                            <input type="text" class="form-control" id="name" name="name" maxlength="100"
                                value="{{ old('name') }}">
                        </div>

                        <div class="form-group">
                            <label for="type" class="d-block">カテゴリー</label>
                            <select class="form-select" name="type">
                                <option value="" selected>カテゴリーを選んでください</option>
                                <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>オレンジ</option>
                                <option value="2" {{ old('type') == 2 ? 'selected' : '' }}>グレープ</option>
                                <option value="3" {{ old('type') == 3 ? 'selected' : '' }}>チョコレート</option>
                                <option value="4" {{ old('type') == 4 ? 'selected' : '' }}>バニラ</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <textarea name="detail" id="detail" name="detail" cols="30" rows="10" class="form-control"
                                maxlength="500">{{ old('detail') }}</textarea>
                        </div>

                        <!-- 画像アップロードフィールド -->
                        <div class="form-group">
                            <label for="image">商品画像</label>
                            <input type="file" name="image" class="form-control" value="{{ old('image') }}"
                                onchange="previewImage(this);">
                            <small class="form-text text-muted">画像ファイルのサイズは64KB以下にしてください。</small>

                            {{-- プレビュー表示エリア --}}
                            <img id="preview" src="" alt="商品画像"
                                style="max-width: 200px; max-height: 200px; display: none;">

                        <div class="form-group">
                            <label for="price">価格</label>
                            <input type="number" name="price" min="1" value="{{ old('price') }}"><span>円</span>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
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
