<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemeController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\PostsLazy;
use App\Models\Meme;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MemeController::class, 'welcome']);

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'auth'])->name('login-action');
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');


Route::resource('memes', MemeController::class)->except(['edit', 'update']);
Route::get('/popular', [MemeController::class, 'popular'])->name('memes.popular');

Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile')->middleware('auth');
Route::put('/user/profile', [UserController::class, 'update'])->name('user.update')->middleware('auth');
