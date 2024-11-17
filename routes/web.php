<?php

use App\Events\ButtonStatusChanged;
use App\Http\Controllers\ButtonController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/toggle-button', function () {
    $newStatus = rand(0, 1) ? 'active' : 'inactive';
    broadcast(new ButtonStatusChanged($newStatus));
    return response()->json(['status' => $newStatus]);
});
Route::post('/send-data',[ButtonController::class,'changeButtonStatus'])->name('send.data');

Route::get('/test-broadcast', function() {
    broadcast(new ButtonStatusChanged('blue'));  // Test with any color
    return 'Event broadcasted!';
});
Route::post('/send-message',[MessageController::class,'sendMessage'])->name('send-message');
