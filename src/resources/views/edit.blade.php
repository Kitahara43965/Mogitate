@php
    $undefinedEntryKind = App\Http\Controllers\ProductController::UNDEFINED_ENTRY_KIND;
    $addEntryKind = App\Http\Controllers\ProductController::ADD_ENTRY_KIND;
    $changeEntryKind = App\Http\Controllers\ProductController::CHANGE_ENTRY_KIND;
    $trashImage = App\Http\Controllers\ProductController::TRASH_IMAGE;
@endphp

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('content')

    <div class="wrapper">
        <div class="entry-section">
            <form action="{{ route('products.update', $productsRecord->id)}}" method="POST" enctype="multipart/form-data" class="left-form">
                @csrf
                <div>
                    <div class="edit-container">

                        @yield('content-return-home')
                        <div class="edit-upper-container">
                            <div class="edit-upper-left-container">
                                @yield('content-image')
                            </div>
                            <div class="edit-upper-right-container">
                                @yield('content-name')
                                @yield('content-price')
                                @yield('content-selected-seasons')
                            </div>
                        </div>
                        <div>
                            @yield('content-description')
                        </div>
                    </div>
                    
                    <div class="bottom-left-form">
                        <div class="input-field-block ">
                            <div class="page-button-group">
                                <a href="/products" class="page-button return-page-button">戻る</a>
                                <button class="page-button update-page-button" type="submit" name="registerType" value="allDataRegisterType">更新</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="bottom-right-form">
                <form action="{{ route('products.delete', $productsRecord->id) }}" method="POST" enctype="multipart/form-data" class="right-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="trash-button">
                        <img class="trash-image" 
                            src="{{ asset('storage/' . $trashImage) }}" 
                            alt="削除">
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection