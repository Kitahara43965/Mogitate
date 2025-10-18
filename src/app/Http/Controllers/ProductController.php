<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product; // DB保存用
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductRequest;


class ProductController extends Controller
{
    public const IMAGE_FILE_PREFIX = 'image';

    public function index()
    {
        return view('index');
    }

    public function show(Request $request)
    {
        return view('register');
    }

    //public function store(Request $request){
    public function store(ProductRequest $request){
        // バリデーション

        /*$validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => $request->input('preview_url') ? 'nullable' : 'required|image|max:2048',
        ]);*/

        $previewUrl = null;
        $imageName = null;

        // 画像アップロード時
        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $originalImageName = $file->getClientOriginalName();

            $extension = pathinfo($originalImageName, PATHINFO_EXTENSION);

            $files = Storage::disk('public')->files('resource');

            // ファイル名が image で始まるものだけフィルター
            $imageFiles = array_filter($files, function ($file) {
                return preg_match('/^resource\/'.self::IMAGE_FILE_PREFIX.'/i', $file);
            });

            $count = count($imageFiles);

            $imageName = self::IMAGE_FILE_PREFIX.($count + 1).'.'.$extension;

            // 保存
            $path = $file->storeAs('resource', $imageName, 'public');
            $previewUrl = asset('storage/' . $path);
        } else {
            $imageName = $request->input('image_name');
            $previewUrl = $request->input('preview_url');
        }

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput([
                    'name' => $request->input('name'),
                    'preview_url' => $previewUrl,
                    'image_name' => $imageName,
                ]);
        }

        /*// DB保存
        Product::create([
            'name' => $request->input('name'),
            'image_name' => $imageName,
            'image_path' => $previewUrl,
        ]);*/

        return back()->with('success', '登録が完了しました');
    }
}
