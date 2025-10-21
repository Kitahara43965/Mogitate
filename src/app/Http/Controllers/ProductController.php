<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;


class ProductController extends Controller
{
    public const UNDEFINED_ENTRY_KIND = 0;
    public const ADD_ENTRY_KIND = 1;
    public const CHANGE_ENTRY_KIND = 2;
    public const IMAGE_FILE_PREFIX = 'image';
    public const TRASH_IMAGE = 'trash.jpeg';
    public const PAGINATED_PAGE_NUMBER = 6;

    public function extractKeywords(string $input, int $limit = -1): array
    {
        return array_values(array_unique(preg_split('/[\p{Z}\p{Cc}]++/u', $input, $limit, PREG_SPLIT_NO_EMPTY)));
    }

    public function conditionedProductsTableGet(Request $request,$contactQuery){
        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $splitedKeywords = $this->extractKeywords($keyword);
            foreach($splitedKeywords as $splitedKeyword){
                $contactQuery->where(function($q) use ($splitedKeyword) {
                    $q->where('name', 'like', "%{$splitedKeyword}%");
                });
            }
        }

        return $contactQuery;

    }//conditionedContactsGet

    public function index(Request $request)
    {
        $seasons = Season::all();
        $keyword = $request->input('keyword','');
        $sort = $request->input('sort','');
        $query = Product::query();
        $query = $this->conditionedProductsTableGet($request,$query);
        if ($request->sort === 'asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'desc') {
            $query->orderBy('price', 'desc');
        }
        $products = $query->paginate(self::PAGINATED_PAGE_NUMBER);

        return view('index', compact('products','seasons','keyword', 'sort'));
    }

    public function show(Request $request)
    {
        $entryKind = self::ADD_ENTRY_KIND;
        $id = 0;
        return($this->onCreate($request,$entryKind,$id));
    }

    public function edit(Request $request,$id)
    {
        $entryKind = self::CHANGE_ENTRY_KIND;
        return($this->onCreate($request,$entryKind,$id));
    }

    function onCreate(Request $request,$entryKind,$id){

        $products = Product::with('seasons')->get();
        $seasons = Season::all();

        if($entryKind == self::ADD_ENTRY_KIND){
            $pivotRecord = null;
            $selectedSeasonRecord = null;
            $productsRecord = null;
        }else if($entryKind == self::CHANGE_ENTRY_KIND){
            $pivotRecord = DB::table('product_season')->where('product_id', $id)->get();
            $selectedSeasonRecord = $pivotRecord->pluck('season_id')->toArray();
            $productsRecord = Product::findOrFail($id);
        }//$entryKind

        if($entryKind == self::ADD_ENTRY_KIND){
            return view('register',compact('seasons','products','selectedSeasonRecord','productsRecord',
            'entryKind'));
        }else if($entryKind == self::CHANGE_ENTRY_KIND){
            return view('register', compact('seasons','products','selectedSeasonRecord','productsRecord',
            'entryKind'));
        }//entryKind

    }//onCreate

    public function update(ProductRequest $request,$id){
        $entryKind = self::CHANGE_ENTRY_KIND;
        return($this->onManage($request,$entryKind,$id));
    }//update

    public function store(ProductRequest $request)
    {
        $id = 0;
        $entryKind = self::ADD_ENTRY_KIND;
        return($this->onManage($request,$entryKind,$id));
    }


    public function onManage(ProductRequest $request,$entryKind,$id)
    {
        $registerType = $request->input('registerType','');
        $products = Product::with('seasons')->get();
        $seasons = Season::all();
        if($entryKind == self::ADD_ENTRY_KIND){
            $pivotRecord = null;
            $selectedSeasonRecord = null;
            $productsRecord = null;
        }else if($entryKind == self::CHANGE_ENTRY_KIND){
            $pivotRecord = DB::table('product_season')->where('product_id', $id)->get();
            $selectedSeasonRecord = $pivotRecord->pluck('season_id')->toArray();
            $productsRecord = Product::findOrFail($id);
        }//$entryKind

        $selectedSeasons = $request->input('selectedSeasons');
        $previewUrl = null;
        $imageName = null;

        if ($registerType === 'allDataRegisterType') {
            if ($request->hasFile('image')) {

                $file = $request->file('image');
                $originalImageName = $file->getClientOriginalName();
                $extension = pathinfo($originalImageName, PATHINFO_EXTENSION);
                $files = Storage::disk('public')->files('');
                $imageFiles = array_filter($files, function ($file) {
                    return preg_match('/'.self::IMAGE_FILE_PREFIX.'/i', $file);
                });

                $count = count($imageFiles);
                $imageName = self::IMAGE_FILE_PREFIX.($count + 1).'.'.$extension;

                // 保存
                $path = $file->storeAs('', $imageName, 'public');
                $previewUrl = asset('storage/' . $path);
            } else {
                $imageName = $request->input('image_name');
                $previewUrl = $request->input('preview_url');
            }
        }//registerType

        if ($registerType === 'allDataRegisterType') {
            if($entryKind == self::ADD_ENTRY_KIND){
                $product = Product::create([
                    'name' => $request->input('name'),
                    'price' => $request->input('price'),
                    'image' => $imageName,
                    'description' => $request->input('description'),
                ]);
                if ($selectedSeasons) {
                    $product->seasons()->attach($selectedSeasons ?? []);
                }
            }else if($entryKind == self::CHANGE_ENTRY_KIND){
                $product = Product::findOrFail($id);
                $product->update([
                    'name' => $request->input('name'),
                    'price' => $request->input('price'),
                    'image' => $imageName,
                    'description' => $request->input('description'),
                ]);
                if ($selectedSeasons) {
                    $product->seasons()->sync($selectedSeasons ?? []);
                }
            }//$entryKind
            return redirect('/products')->with('imageMessage', '登録が完了しました！');
        }else{//$registerType
            return redirect()->route('products.index');
        }//$registerType
    }

    public function delete(Request $request,$id){
        $product = Product::findOrFail($id);
        $product->seasons()->detach();
        $product->delete();
        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }

    public function designate() {
        $files = Storage::disk('public')->files('');
        $imageFiles = array_filter($files, function ($file) {
            return preg_match('/image/i', $file);
        });
        return response()->json(['count' => count($imageFiles)]);
    }
}
