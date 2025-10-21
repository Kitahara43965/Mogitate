@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

    

    <div class="card-body">
        <div class="page-header">
            <h1 class="h1-padding">商品一覧</h1>
            <a href="{{ route('products.show') }}" class="register-button">+ 商品を追加  </a>
        </div>

        <div class="card-setting-section">
            <form action="{{ route('products.search') }}" method="GET">
                <div>
                    <input type="text" class="search-edit-text" name="keyword" value="{{ request('keyword') }}" placeholder="商品名で検索">
                </div>
                <div>
                    <button class="search-button" type="submit">検索</button>
                </div>
                <div class="price-note">価格順で表示</div>
                <div>
                    <select class="search-option" name="sort" id="sortSelect" data-url="{{ route('products.search') }}">
                        <option value="" disabled selected>価格で並べ替え</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>安い順に表示</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>高い順に表示</option>
                    </select>
                </div>
                
                @if($sort === 'asc')
                    <div class="search-circle-button-outline">
                        <div>安い順に表示</div>
                        <a href="{{ route('products.search') }}" class="circle-button">✖︎</a>
                    </div>
                @elseif($sort === 'desc')
                    <div class="search-circle-button-outline">
                        <div>高い順に表示</div>
                        <a href="{{ route('products.search') }}" class="circle-button">✖︎</a>
                    </div>
                @endif
                
            </form>
            <div class="card-section">
                <div class="card-container">
                    @foreach($products as $product)
                        <a href="{{ route('products.edit', ['productId' => $product->id]) }}" class="product-card">
                            <div class="image-preview-container">
                                <img src="{{ asset('storage/' . $product->image) }}" class="preview-image">
                            </div>
                            <div class="card-footer">
                                <span class="product-name">{{ $product->name }}</span>
                                <span class="product-price">¥{{ $product->price }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="pagination-container">
                    {{-- 前のページ --}}
                    @if($products->lastPage() >= 2)
                        @if ($products->onFirstPage())
                            <button class="page-btn"><</button>
                        @else
                            <button onclick="window.location='{{ $products->appends(['keyword' => $keyword, 'sort' => $sort])->previousPageUrl() }}'" class="page-btn"><</button>
                        @endif

                        {{-- ページ番号 --}}
                        @for ($page = 1; $page <= $products->lastPage(); $page++)
                            @if ($page == $products->currentPage())
                                <button disabled class="page-btn current">{{ $page }}</button>
                            @else
                                <button onclick="window.location='{{ $products->appends(['keyword' => $keyword, 'sort' => $sort])->url($page) }}'" class="page-btn">{{ $page }}</button>
                            @endif
                        @endfor

                        {{-- 次のページ --}}
                        @if ($products->hasMorePages())
                            <button onclick="window.location='{{ $products->appends(['keyword' => $keyword, 'sort' => $sort])->nextPageUrl() }}'" class="page-btn">></button>
                        @else
                            <button class="page-btn">></button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="/js/option_order.js"></script>

@endsection