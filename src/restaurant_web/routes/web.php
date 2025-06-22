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
use App\Http\Controllers\Admin\ErrorLogController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\Admin\SubCategoryController;
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

// Admin Authentication and Public Routes
Route::prefix('admin')->group(function () {
    // Main admin route that checks authentication
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    // Admin authentication routes
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout')->middleware('auth');
    // Error logging route (no auth required for client-side errors)
    Route::post('/log-error', [ErrorLogController::class, 'logClientError'])->name('admin.log-error');

    // Protected admin routes
    Route::middleware(['auth', 'auth.admin'])->group(function () {
        // Dashboard & Reports
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/reports', [DashboardController::class, 'reports'])->name('admin.reports');

        // Categories CRUD & Custom Actions
        Route::resource('categories', CategoryController::class, ['as' => 'admin']);
        Route::get('categories/data/get', [CategoryController::class, 'getData'])->name('admin.categories.data');
        Route::post('categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('admin.categories.bulk-delete');
        Route::post('categories/bulk-status', [CategoryController::class, 'bulkStatus'])->name('admin.categories.bulk-status');
        Route::post('categories/check-name', [CategoryController::class, 'checkName'])->name('admin.categories.check-name');
        Route::patch('categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('admin.categories.toggle-status');

        // Menu CRUD & Custom Actions
        Route::resource('menu', MenuController::class, ['as' => 'admin']);
        Route::get('menu/data/get', [MenuController::class, 'getData'])->name('admin.menu.data');
        Route::post('menu/bulk-delete', [MenuController::class, 'bulkDelete'])->name('admin.menu.bulk-delete');
        Route::post('menu/bulk-status', [MenuController::class, 'bulkStatus'])->name('admin.menu.bulk-status');
        Route::patch('menu/{id}/toggle-status', [MenuController::class, 'toggleStatus'])->name('admin.menu.toggle-status');

        // Orders CRUD & Custom Actions
        Route::resource('orders', OrderController::class, ['as' => 'admin']);
        Route::get('orders/data/get', [OrderController::class, 'getData'])->name('admin.orders.data');
        Route::get('orders/pending', [OrderController::class, 'pending'])->name('admin.orders.pending');
        Route::get('orders/completed', [OrderController::class, 'completed'])->name('admin.orders.completed');
        Route::post('orders/bulk-delete', [OrderController::class, 'bulkDelete'])->name('admin.orders.bulk-delete');
        Route::post('orders/bulk-status', [OrderController::class, 'bulkStatus'])->name('admin.orders.bulk-status');
        Route::patch('orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status.update');

        // Reservations CRUD & Custom Actions
        Route::resource('reservations', ReservationController::class, ['as' => 'admin']);
        Route::get('reservations/data/get', [ReservationController::class, 'getData'])->name('admin.reservations.data');
        Route::get('reservations/pending', [ReservationController::class, 'pending'])->name('admin.reservations.pending');
        Route::get('reservations/completed', [ReservationController::class, 'completed'])->name('admin.reservations.completed');
        Route::post('reservations/bulk-delete', [ReservationController::class, 'bulkDelete'])->name('admin.reservations.bulk-delete');
        Route::post('reservations/bulk-status', [ReservationController::class, 'bulkStatus'])->name('admin.reservations.bulk-status');
        Route::patch('reservations/{id}/status', [ReservationController::class, 'updateStatus'])->name('admin.reservations.status.update');

        // Tables CRUD & Custom Actions
        Route::resource('tables', TableController::class, ['as' => 'admin']);
        Route::get('tables/data/get', [TableController::class, 'getData'])->name('admin.tables.data');
        Route::post('tables/bulk-delete', [TableController::class, 'bulkDelete'])->name('admin.tables.bulk-delete');
        Route::post('tables/bulk-status', [TableController::class, 'bulkStatus'])->name('admin.tables.bulk-status');
        Route::patch('tables/{id}/toggle-status', [TableController::class, 'toggleStatus'])->name('admin.tables.toggle-status');

        // Customers CRUD & Custom Actions
        Route::resource('customers', CustomerController::class, ['as' => 'admin']);
        Route::get('customers/data/get', [CustomerController::class, 'getData'])->name('admin.customers.data');
        Route::post('customers/bulk-delete', [CustomerController::class, 'bulkDelete'])->name('admin.customers.bulk-delete');
        Route::post('customers/bulk-status', [CustomerController::class, 'bulkStatus'])->name('admin.customers.bulk-status');
        Route::patch('customers/{id}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('admin.customers.toggle-status');

        // Users CRUD & Custom Actions
        Route::resource('users', UserController::class, ['as' => 'admin']);
        Route::get('users/data/get', [UserController::class, 'getData'])->name('admin.users.data');
        Route::post('users/bulk-delete', [UserController::class, 'bulkDelete'])->name('admin.users.bulk-delete');
        Route::post('users/bulk-status', [UserController::class, 'bulkStatus'])->name('admin.users.bulk-status');
        Route::patch('users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');

        // Error Logs
        Route::get('error-logs', [ErrorLogController::class, 'index'])->name('admin.error-logs.index');
        Route::get('error-logs/{id}', [ErrorLogController::class, 'show'])->name('admin.error-logs.show');
        Route::post('error-logs/clear-old', [ErrorLogController::class, 'clearOld'])->name('admin.error-logs.clear-old');
        Route::get('error-logs/export', [ErrorLogController::class, 'export'])->name('admin.error-logs.export');

        // Settings
        Route::get('settings', [SettingController::class, 'index'])->name('admin.settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('admin.settings.update');
        Route::post('settings/reset', [SettingController::class, 'reset'])->name('admin.settings.reset');
        Route::get('settings/backup', [SettingController::class, 'backup'])->name('admin.settings.backup');
        Route::post('settings/restore', [SettingController::class, 'restore'])->name('admin.settings.restore');

        // Test page for AJAX and SweetAlert demonstration
        Route::get('/test', function () {
            return view('admin.pages.test');
        })->name('admin.test');

        // SubCategories CRUD
        Route::resource('subcategories', SubCategoryController::class, ['as' => 'admin']);
        Route::get('subcategories/data/get', [SubCategoryController::class, 'getData'])->name('admin.subcategories.data');
        Route::post('subcategories/bulk-delete', [SubCategoryController::class, 'bulkDelete'])->name('admin.subcategories.bulk-delete');
        Route::post('subcategories/bulk-status', [SubCategoryController::class, 'bulkStatus'])->name('admin.subcategories.bulk-status');
        Route::patch('subcategories/{id}/toggle-status', [SubCategoryController::class, 'toggleStatus'])->name('admin.subcategories.toggle-status');
        Route::post('subcategories/check-name', [SubCategoryController::class, 'checkName'])->name('admin.subcategories.check-name');
    });
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/dialogflow/webhook', [ChatBotController::class, 'handleRequest']);

Route::get('/testChatbot', function () {
    return view('test'); // Call the view here
});
Route::get('/clear-cache', function () {
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    \Artisan::call('config:cache');
    \Artisan::call('optimize');

    return redirect()->back()->with('status', 'Cache cleared and optimized successfully!');
});

