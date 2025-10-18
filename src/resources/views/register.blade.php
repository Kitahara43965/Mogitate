@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<form action="{{ route('products.register') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>商品画像（必須）</label><br>

    <!-- プレビュー -->
    <img id="preview" src="{{ old('preview_url') }}" 
         style="max-width:300px; {{ old('preview_url') ? '' : 'display:none;' }}">

    <!-- hiddenでプレビュー用URLとファイル名を保持 -->
    <input type="hidden" name="preview_url" value="{{ old('preview_url') }}">
    <input type="hidden" name="image_name" value="{{ old('image_name') }}">

    <!-- ファイル選択 -->
    <input type="file" id="imageInput" name="image" accept="image/*">

    <!-- ファイル名表示（readonlyでOK） -->
    <input type="text" id="imageName" value="{{ old('image_name') }}" readonly>

    @error('image')
    <p style="color:red;">{{ $message }}</p>
    @enderror

    <label>商品名</label><br>
    <input type="text" name="name" value="{{ old('name') }}">
    @error('name')
    <p style="color:red;">{{ $message }}</p>
    @enderror

    <button type="submit">送信</button>

    <script src="/js/preview_filename.js"></script>
    
</form>

@endsection