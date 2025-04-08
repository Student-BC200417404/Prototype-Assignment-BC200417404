<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
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
Route::get('/login', [AuthController::class, 'showUserLogin'])->name('login');
Route::post('/login', [AuthController::class, 'userLogin'])->name('login.submit');

// Registration Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    // Main admin route that checks authentication
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    
    // Admin authentication routes
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])
        ->name('admin.logout')
        ->middleware('auth');
    
    // Protected admin routes
    Route::middleware(['auth'])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Menu Management
        Route::get('menu', [MenuController::class, 'index'])->name('admin.menu.index');
        Route::get('menu/create', [MenuController::class, 'create'])->name('admin.menu.create');
        Route::post('menu', [MenuController::class, 'store'])->name('admin.menu.store');
        Route::get('menu/{id}/edit', [MenuController::class, 'edit'])->name('admin.menu.edit');
        Route::put('menu/{id}', [MenuController::class, 'update'])->name('admin.menu.update');
        Route::delete('menu/{id}', [MenuController::class, 'destroy'])->name('admin.menu.destroy');
        Route::get('menu/data', [MenuController::class, 'getData'])->name('admin.menu.data');

        // Categories
        Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
        Route::get('/categories/data', [CategoryController::class, 'getData'])->name('admin.categories.data');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');

        // Orders
        Route::prefix('orders')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('admin.orders.index');
            Route::get('/pending', [OrderController::class, 'pending'])->name('admin.orders.pending');
            Route::get('/completed', [OrderController::class, 'completed'])->name('admin.orders.completed');
            Route::get('/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
            Route::patch('/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status.update');
        });

        // Reservations
        Route::prefix('reservations')->group(function () {
            Route::get('/', [ReservationController::class, 'index'])->name('admin.reservations.index');
            Route::get('/pending', [ReservationController::class, 'pending'])->name('admin.reservations.pending');
            Route::get('/create', [ReservationController::class, 'create'])->name('admin.reservations.create');
            Route::post('/', [ReservationController::class, 'store'])->name('admin.reservations.store');
            Route::patch('/{reservation}/status', [ReservationController::class, 'updateStatus'])->name('admin.reservations.status.update');
        });

        // Tables
        Route::get('tables', [TableController::class, 'index'])->name('admin.tables.index');
        Route::get('tables/create', [TableController::class, 'create'])->name('admin.tables.create');
        Route::post('tables', [TableController::class, 'store'])->name('admin.tables.store');
        Route::get('tables/{id}/edit', [TableController::class, 'edit'])->name('admin.tables.edit');
        Route::put('tables/{id}', [TableController::class, 'update'])->name('admin.tables.update');
        Route::delete('tables/{id}', [TableController::class, 'destroy'])->name('admin.tables.destroy');

        // Customers
        Route::get('customers', [CustomerController::class, 'index'])->name('admin.customers.index');
        Route::get('customers/create', [CustomerController::class, 'create'])->name('admin.customers.create');
        Route::post('customers', [CustomerController::class, 'store'])->name('admin.customers.store');
        Route::get('customers/{id}/edit', [CustomerController::class, 'edit'])->name('admin.customers.edit');
        Route::put('customers/{id}', [CustomerController::class, 'update'])->name('admin.customers.update');
        Route::delete('customers/{id}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy');

        // Staff
        Route::get('user', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('user/create', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('user', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::put('user/{id}', [UserController::class, 'update'])->name('admin.user.update');
        Route::delete('user/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');

        // Settings
        Route::prefix('settings')->group(function () {
            Route::get('/general', [SettingController::class, 'general'])->name('admin.settings.general');
            Route::post('/general', [SettingController::class, 'updateGeneral']);
            Route::get('/profile', [SettingController::class, 'profile'])->name('admin.profile');
            Route::post('/profile', [SettingController::class, 'updateProfile']);
        });

        // Reports
        Route::get('/reports', [DashboardController::class, 'reports'])->name('admin.reports');
    });
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/chatbot', [WebController::class, 'chatbot'])->name('chatbot');