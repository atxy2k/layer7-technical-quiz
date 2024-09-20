<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::prefix('articles')->middleware(['auth','verified'])->group(function(){
    Route::get('', [ArticlesController::class,'index'])->name('dashboard');
    Route::get( 'add', [ ArticlesController::class,'add'])->name('articles.add');
    Route::post('store',[ArticlesController::class,'store'])->name('articles.store');
    Route::get( 'change/{id}', [ ArticlesController::class,'change'])->name('articles.change');
    Route::post('store-change/{id}',[ArticlesController::class,'storeChange'])->name('articles.store-change');
    Route::get( 'show/{id}', [ ArticlesController::class,'show'])->name('articles.show');
    Route::get('delete/{id}', [ArticlesController::class,'delete'])->name('articles.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
