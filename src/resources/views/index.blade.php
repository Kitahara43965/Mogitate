@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<form method="GET" action="{{ route('products.show') }}">
  <button type="submit">登録画面</button>
</form>

<div>
  <div>
    INDEX
  </div>
</div>

@endsection