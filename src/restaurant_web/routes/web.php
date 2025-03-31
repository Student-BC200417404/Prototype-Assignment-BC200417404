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
use App\Http\Controllers\Admin\StaffController;
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
        Route::resource('menu', MenuController::class)->names([
            'index' => 'admin.menu.index',
            'create' => 'admin.menu.create',
            'store' => 'admin.menu.store',
            'edit' => 'admin.menu.edit',
            'update' => 'admin.menu.update',
            'destroy' => 'admin.menu.destroy',
        ]);

        // Categories
        Route::resource('categories', CategoryController::class)->names([
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'store' => 'admin.categories.store',
            'edit' => 'admin.categories.edit',
            'update' => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy',
        ]);

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
        Route::resource('tables', TableController::class)->names([
            'index' => 'admin.tables.index',
            'create' => 'admin.tables.create',
            'store' => 'admin.tables.store',
            'edit' => 'admin.tables.edit',
            'update' => 'admin.tables.update',
            'destroy' => 'admin.tables.destroy',
        ]);

        // Customers
        Route::resource('customers', CustomerController::class)->names([
            'index' => 'admin.customers.index',
            'create' => 'admin.customers.create',
            'store' => 'admin.customers.store',
            'edit' => 'admin.customers.edit',
            'update' => 'admin.customers.update',
            'destroy' => 'admin.customers.destroy',
        ]);

        // Staff
        Route::resource('staff', StaffController::class)->names([
            'index' => 'admin.staff.index',
            'create' => 'admin.staff.create',
            'store' => 'admin.staff.store',
            'edit' => 'admin.staff.edit',
            'update' => 'admin.staff.update',
            'destroy' => 'admin.staff.destroy',
        ]);

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