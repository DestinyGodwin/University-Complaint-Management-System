<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/complaints/{complaint}', [AdminController::class, 'show'])->name('complaints.show');
    Route::put('/complaints/{complaint}/assign', [AdminController::class, 'assign'])->name('complaints.assign');
    Route::put('/complaints/{complaint}/resolve', [AdminController::class, 'resolve'])->name('complaints.resolve');
    Route::put('/complaints/{complaint}/escalate', [AdminController::class, 'escalate'])->name('complaints.escalate');
    Route::post('/complaints/{complaint}/comments', [CommentController::class, 'store'])->name('complaints.comments.store');
});

// Staff Routes
Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/', [StaffController::class, 'index'])->name('index');
    Route::get('/complaints/{complaint}', [StaffController::class, 'show'])->name('complaints.show');
    Route::put('/complaints/{complaint}/resolve', [StaffController::class, 'resolve'])->name('complaints.resolve');
    Route::put('/complaints/{complaint}/escalate', [StaffController::class, 'escalate'])->name('complaints.escalate');
    Route::post('/complaints/{complaint}/comments', [CommentController::class, 'store'])->name('complaints.comments.store');
});

// Student Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('dashboard');
    Route::get('/complaints/create', [StudentController::class, 'create'])->name('complaints.create');
    Route::post('/complaints', [StudentController::class, 'store'])->name('complaints.store');
    Route::get('/complaints/{complaint}', [StudentController::class, 'show'])->name('complaints.show');
    Route::post('/complaints/{complaint}/comments', [CommentController::class, 'store'])->name('complaints.comments.store');
    Route::get('/complaints/{complaint}/file/view', [StudentController::class, 'viewFile'])->name('complaints.viewFile');
    Route::get('/complaints/{complaint}/file/download', [StudentController::class, 'downloadFile'])->name('complaints.downloadFile');
});

Route::get('complaints/{id}/preview-file', [ComplaintController::class, 'previewFile'])->name('complaints.preview');
Route::get('complaints/{id}/download-file', [ComplaintController::class, 'downloadFile'])->name('complaints.download');

// Authentication Routes
Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/', function (){
    return view('welcome');
});