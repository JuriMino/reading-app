<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', fn()=>redirect()->route('books.index'));

Route::prefix('books')->name('books.')->controller(BookController::class)->group(function(){
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/{book}', 'show')->name('show');
    Route::get('/{book}/edit', 'edit')->name('edit');
    Route::put('/{book}', 'update')->name('update');
    Route::delete('/{book}', 'destroy')->name('destroy');
    Route::patch('/{book}/status', 'updateStatus')->name('updateStatus');
});
