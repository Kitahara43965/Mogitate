@php
    $undefinedEntryKind = App\Http\Controllers\ProductController::UNDEFINED_ENTRY_KIND;
    $addEntryKind = App\Http\Controllers\ProductController::ADD_ENTRY_KIND;
    $changeEntryKind = App\Http\Controllers\ProductController::CHANGE_ENTRY_KIND;
    $trashImage = App\Http\Controllers\ProductController::TRASH_IMAGE;
@endphp

@php
    if($entryKind === $addEntryKind){
        $layout = 'show';
    }else if($entryKind === $changeEntryKind){
        $layout = 'edit';
    }else{//$entryKind
        $layout = 'show';
    }//$entryKind
@endphp

@extends($layout)

@section('content-return-home')
    <div class="input-field-block">
        <div class="return-home-href-group">
            <a href="{{ route('products.index') }}" class="return-home-href">商品一覧</a><div> > キウイ</div>
        </div>
    </div>
@endsection

@section('content-name')
    <div class="input-field-block">
        @php
            $oldName = old('name');
            if($entryKind === $addEntryKind){
                $embeddedName = null;
            }else if($entryKind === $changeEntryKind){
                $embeddedName = $productsRecord->name;
            }else{//$entryKind
                $embeddedName = null;
            }//$entryKind
            $newName = $oldName ? $oldName : $embeddedName;
        @endphp
        <div class="inner-input-field-block data-label-row">
            <label class="data-label-row-title">商品名</label>
            @if($entryKind === $addEntryKind)
                <div class="must-item">必須</div>
            @endif
        </div>
        <div class="center-child-block">
            <input class="edit-text" type="text" name="name" value="{{$newName}}" placeholder="商品名を入力">
        </div>
        <div class="left-child-block">
            @if ($errors->has('name'))
                <ul class="form-error-group">
                    @foreach ($errors->get('name') as $error)
                        <li class="form-error">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection

@section('content-price')
    <div class="input-field-block">
        @php
            $oldPrice = old('price');
            if($entryKind === $addEntryKind){
                $embeddedPrice = null;
            }else if($entryKind === $changeEntryKind){
                $embeddedPrice = $productsRecord->price;
            }else{//$entryKind
                $embeddedPrice = null;
            }//$entryKind
            $newPrice = $oldPrice ? $oldPrice : $embeddedPrice;
        @endphp
        <div class="inner-input-field-block data-label-row">
            <label class="data-label-row-title">値段</label>
            @if($entryKind === $addEntryKind)
                <div class="must-item">必須</div>
            @endif
        </div>
        <div class="center-child-block">
            <input class="edit-text" type="text" name="price" value="{{ $newPrice }}" placeholder="値段を入力">
        </div>
        <div class="left-child-block">
            @if ($errors->has('price'))
                <ul class="form-error-group">
                    @foreach ($errors->get('price') as $error)
                        <li class="form-error">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection

@section('content-image')
    <div class="input-field-block">
        @php
            $oldImageName = old('image_name');
            $oldPreviewUrl = old('preview_url'); 
            if($entryKind === $addEntryKind){
                $embeddedImageName = null;
                $embeddedPreviewUrl = null;
            }else if($entryKind === $changeEntryKind){
                $embeddedImageName = $productsRecord->image;
                $embeddedPreviewUrl = asset('storage/' . $embeddedImageName);
            }else{//$entryKind
                $embeddedImageName = null;
                $embeddedPreviewUrl = null;
            }//$entryKind
            $candidateNewImageName = $oldImageName ? $oldImageName : $embeddedImageName;
            $candidateNewPreviewUrl = $oldPreviewUrl ? $oldPreviewUrl : $embeddedPreviewUrl;
            $newImageName = null;
            $newPreviewUrl = null;
            if($candidateNewPreviewUrl){
                $newImageName = $candidateNewImageName;
                $newPreviewUrl = $candidateNewPreviewUrl;
            }//$candidateNewPreviewUrl
        @endphp

        
        <div class="inner-input-field-block data-label-row">
            <label class="data-label-row-title">商品画像</label>
            @if($entryKind === $addEntryKind)
                <div class="must-item">必須</div>
            @endif
        </div>
        <div class="inner-input-field-block left-child-block">
        <!-- プレビュー -->
            
            <div class="custom-file">
                <div class="image-preview-container" style="{{ $newPreviewUrl ? '' : 'display:none;' }}">
                    <img id="preview"
                        src="{{ $newPreviewUrl ?? '' }}"
                        class="preview-image"
                        style="{{ $newPreviewUrl ? '' : 'display:none;' }}">
                </div>
                <div class="file-upload-commands">
                    <label class="file-upload-button">
                        <input type="file" id="imageInput" name="image" accept="image/*">
                        ファイルを選択
                    </label>
                    <div>
                        <!-- ファイル名表示（readonlyでOK） -->
                        <input class="image-name-edit-text" type="text" id="imageName" value="{{ $newImageName }}" readonly>

                        <!-- hiddenでプレビュー用URLとファイル名を保持 -->
                        <input type="hidden" name="preview_url" value="{{ $newPreviewUrl }}">
                        <input type="hidden" name="image_name" value="{{ $newImageName }}">
                    </div>
                </div>
            </div>
            
            <div class="left-child-block">
               @if ($errors->has('image'))
                    <ul class="form-error-group">
                        @foreach ($errors->get('image') as $error)
                            <li class="form-error">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        
            <script src="/js/preview_filename.js"></script>
        </div>
    </div>
@endsection

@section('content-selected-seasons')
    <div  class="input-field-block">
        @php
            $oldSelectedSeasons = old('selectedSeasons');
            if($entryKind === $addEntryKind){
                $embeddedSelectedSeasons = null;
            }else if($entryKind === $changeEntryKind){
                $embeddedSelectedSeasons = $selectedSeasonRecord;
            }else{//$entryKind
                $embeddedSelectedSeasons = null;
            }//$entryKind
            $newSelectedSeasons = $oldSelectedSeasons ? $oldSelectedSeasons : $embeddedSelectedSeasons;
        @endphp


        <div class="inner-input-field-block data-label-row">
            <label class="data-label-row-title">季節</label>
            @if($entryKind === $addEntryKind)
                <div class="must-item">必須</div>
                <div class="notice-item">複数選択可能</div>
            @endif
        </div>

        @if($entryKind === $addEntryKind)
            <div class="show-season-group-location">
        @elseif($entryKind === $changeEntryKind)
            <div class="edit-season-group-location">
        @else
            <div class="show-season-group-location">
        @endif


            <div class="inner-input-field-block season-group left-child-block">
                @foreach($seasons as $season)
                    <label class="season-option">
                        <input class="season-checkbox" 
                            type="checkbox"
                            class="season-checkbox"
                            name="selectedSeasons[]"
                            value="{{ $season->id }}"
                            @if( (is_array($newSelectedSeasons) && in_array($season->id, $newSelectedSeasons)))
                                checked
                            @endif
                        >
                        {{ $season->name }}
                    </label>
                @endforeach
            </div>
        </div>
        <div class="left-child-block">
            @if ($errors->has('selectedSeasons'))
                <ul class="form-error-group">
                    @foreach ($errors->get('selectedSeasons') as $error)
                        <li class="form-error">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection

@section('content-description')
    <div class="input-field-block">
        @php
            $oldDescription = old('description');
            if($entryKind === $addEntryKind){
                $embeddedDescription = null;
            }else if($entryKind === $changeEntryKind){
                $embeddedDescription = $productsRecord->description;
            }else{//$entryKind
                $embeddedDescription = null;
            }//$entryKind
            $newDescription = $oldDescription ? $oldDescription : $embeddedDescription;
        @endphp

        <div class="inner-input-field-block data-label-row">
            <label class="data-label-row-title">商品説明</label>
            @if($entryKind === $addEntryKind)
                <div class="must-item">必須</div>
            @endif
        </div>
        <div class="center-child-block">
            <textarea class="description-edit-text" name="description" placeholder="商品の説明を入力">{{ $newDescription }}</textarea>
        </div>
        <div class="left-child-block">
            @if ($errors->has('description'))
                <ul class="form-error-group">
                    @foreach ($errors->get('description') as $error)
                        <li class="form-error">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection

