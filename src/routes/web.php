<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;


    Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/register', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
    Route::post('/products/register', [\App\Http\Controllers\ProductController::class, 'store'])->name('products.register');
    Route::get('/products/search', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.search');
    Route::get('/products/{productId}', [\App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/{productId}/update', [\App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{productId}/delete', [\App\Http\Controllers\ProductController::class, 'delete'])->name('products.delete');



    Route::get('/count-images', function () {
        $files = Storage::disk('public')->files('');
        $imageFiles = array_filter($files, function ($file) {
            return preg_match('/image/i', $file);
        });
        return response()->json(['count' => count($imageFiles)]);
    });



