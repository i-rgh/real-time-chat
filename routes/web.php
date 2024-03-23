<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ChatController;
use \App\Http\Controllers\PrivateMessageController;
use \App\Http\Controllers\MessageController;
use \App\Http\Controllers\ChatRoomController;
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware('auth')->group(function () {

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });



    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['verified'])->name('dashboard');


    Route::get('chat' , [ChatController::class, 'show'])->name('chat');
    Route::resource('private-chat' , PrivateMessageController::class)
        ->except('update', 'delete', 'edit', 'index');


    Route::prefix('chat-room')->name('chat-room.')->group(function () {
        Route::resource('/', ChatRoomController::class)
            ->except('update', 'delete', 'edit');
        Route::post('/message', [MessageController::class,'store'])->name('message.store');
    });




});

require __DIR__.'/auth.php';
