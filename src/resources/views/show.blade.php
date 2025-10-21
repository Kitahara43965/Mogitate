@php
    $undefinedEntryKind = App\Http\Controllers\ProductController::UNDEFINED_ENTRY_KIND;
    $addEntryKind = App\Http\Controllers\ProductController::ADD_ENTRY_KIND;
    $changeEntryKind = App\Http\Controllers\ProductController::CHANGE_ENTRY_KIND;
    $trashImage = App\Http\Controllers\ProductController::TRASH_IMAGE;
@endphp

@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')

    <div class="wrapper">
        <div class="entry-section">
            <form action="{{ route('products.register') }}" method="POST" enctype="multipart/form-data" class="left-form">
                @csrf
                <div>
                    <h1>登録画面</h1>

                    @yield('content-name')
                    <br>
                    @yield('content-price')
                    <br>
                    @yield('content-image')
                    <br>
                    @yield('content-selected-seasons')
                    <br>
                    @yield('content-description')
                    
                    <div class="bottom-left-form">
                        <div class="input-field-block ">
                            <div class="page-button-group">
                                <a href="/products" class="page-button return-page-button">戻る</a>
                                <button class="page-button update-page-button" type="submit" name="registerType" value="allDataRegisterType">登録</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection