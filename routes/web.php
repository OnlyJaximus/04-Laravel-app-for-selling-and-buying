<?php

use App\Http\Controllers\AdController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', [AdController::class, 'index'])->name('welcome');
Route::get('/single-ad/{id}', [AdController::class, 'show'])->name('singleAd');
Route::post('/single-ad/{id}/sendMessage', [AdController::class, 'sendMessage'])->name('sendMessage');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/add-deposit', [App\Http\Controllers\HomeController::class, 'addDeposit'])->name('home.addDeposit');

Route::get('/home/show-ad-form', [App\Http\Controllers\HomeController::class, 'showAdForm'])->name('home.showAdForm');
Route::get('/home/ad/{id}', [App\Http\Controllers\HomeController::class, 'showSingleAd'])->name('home.singleAd');

Route::get('/home/message', [App\Http\Controllers\HomeController::class, 'showMessage'])->name('home.showMessage');


// Brisanje
Route::get('/home/{id}/delete', [App\Http\Controllers\HomeController::class, 'msgDelete'])->name('home.dltMsg');

// Edit
Route::get('/home/{id}/edit', [App\Http\Controllers\HomeController::class, 'edit'])->name('home.editPost');
Route::put('/home/{id}/update', [App\Http\Controllers\HomeController::class, 'update'])->name('home.updatePost');

// Delete
Route::get('/home/{id}/delete', [App\Http\Controllers\HomeController::class, 'delete'])->name('home.dltPost');



//
Route::get('/home/message/reply', [App\Http\Controllers\HomeController::class, 'reply'])->name('home.reply');
Route::post('/home/message/reply', [App\Http\Controllers\HomeController::class, 'replyStore'])->name('home.replyStore');




Route::post('/home/add-deposit', [App\Http\Controllers\HomeController::class, 'updateDeposit'])->name('home.addDeposit');

Route::post('/home/save-ad', [App\Http\Controllers\HomeController::class, 'saveAd'])->name('home.saveAd');
