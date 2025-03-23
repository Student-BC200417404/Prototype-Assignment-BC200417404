<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
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

Route::get('/', [WebController::class, 'index'])->name('home');
Route::get('/about', [WebController::class, 'about'])->name('about');
Route::get('/menu', [WebController::class, 'menu'])->name('menu');
Route::get('/contact', [WebController::class, 'contact'])->name('contact');
Route::get('/login', [WebController::class, 'login'])->name('login');
Route::get('/chatbot', [WebController::class, 'chatbot'])->name('chatbot');