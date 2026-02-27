<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\ActivityLogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Borrowing Routes - Export harus di atas resource!
    Route::get('/borrowings/export/csv', [BorrowingController::class, 'export'])->name('borrowings.export');
    Route::get('/borrowings/print', [BorrowingController::class, 'printReport'])->name('borrowings.print');
    Route::resource('borrowings', BorrowingController::class);
    Route::post('/borrowings/{borrowing}/approve', [BorrowingController::class, 'approve'])->name('borrowings.approve');
    Route::post('/borrowings/{borrowing}/reject', [BorrowingController::class, 'reject'])->name('borrowings.reject');
    
    // Return Routes - Export harus di atas other routes!
    Route::get('/returns/export/csv', [ReturnController::class, 'export'])->name('returns.export');
    Route::get('/returns/print', [ReturnController::class, 'printReport'])->name('returns.print');
    Route::get('/returns', [ReturnController::class, 'index'])->name('returns.index');
    Route::get('/returns/{borrowing}/create', [ReturnController::class, 'create'])->name('returns.create');
    Route::post('/returns/{borrowing}', [ReturnController::class, 'store'])->name('returns.store');
    
    // Admin Routes
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('tools', ToolController::class);
        Route::resource('activity-logs', ActivityLogController::class, ['only' => ['index']]);
        Route::get('/activity-logs/export', [ActivityLogController::class, 'export'])->name('activity-logs.export');
    });
});

