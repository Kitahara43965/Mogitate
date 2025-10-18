<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;


Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products');
Route::get('/products/register', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::post('/products/register', [\App\Http\Controllers\ProductController::class, 'store'])->name('products.register');

Route::get('/count-images', function () {
    $files = Storage::disk('public')->files('resource');
    $imageFiles = array_filter($files, function ($file) {
        return preg_match('/^resource\/image/i', $file);
    });
    return response()->json(['count' => count($imageFiles)]);
});



