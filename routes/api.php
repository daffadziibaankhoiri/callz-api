<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\MitraAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\MitraVerificationController;
use App\Http\Controllers\OmzetController;
use App\Http\Controllers\PackageCategoryController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskRatingController;
use Illuminate\Support\Facades\Storage; 

// Single login endpoint
Route::post('auth/login', [AuthController::class, 'login']);

// Register tetap terpisah
Route::post('auth/user/register',   [UserAuthController::class, 'register']);
Route::post('auth/mitra/register',  [MitraAuthController::class, 'register']);

// Jalur Masuk Khusus Admin Terpisah
Route::post('auth/admin/register',  [AdminAuthController::class, 'register']);
Route::post('auth/admin/login',     [AdminAuthController::class, 'login']); 
// ==========================================
// PROTECTED ROUTES FOR USER (PEMINTA TUGAS)
// ==========================================
Route::middleware('auth:user')->group(function () {
    Route::post('auth/user/logout', [UserAuthController::class, 'logout']);
    Route::get('auth/user/me',      [UserAuthController::class, 'me']);
    Route::post('auth/user/update-avatar', [UserAuthController::class, 'updateAvatar']);
    Route::put('auth/user/update',         [UserAuthController::class, 'update']);
    Route::put('auth/user/update-location', [UserAuthController::class, 'updateLocation']);

    // Endpoint Riwayat Terpisah untuk User
    Route::get('tasks/history',     [TaskController::class, 'userHistory']); // <-- BARU: Riwayat tugas user
    
    // CRUD Utama Tugas untuk User
    Route::post('tasks',            [TaskController::class, 'store']);   
    Route::get('tasks/{id}',        [TaskController::class, 'show']);    
    Route::put('tasks/{id}',        [TaskController::class, 'update']);  
    Route::delete('tasks/{id}',     [TaskController::class, 'destroy']); 
    Route::post('tasks/{id}/rate-mitra', [TaskRatingController::class, 'rateMitra']);

    // Konfirmasi & reject bukti kerja dari mitra
    Route::post('tasks/{id}/confirm',      [TaskController::class, 'confirmTask']);
    Route::post('tasks/{id}/reject-proof', [TaskController::class, 'rejectProof']);
});

// ==========================================
// PROTECTED ROUTES FOR MITRA (PENGERJA TUGAS)
// ==========================================
Route::middleware('auth:mitra')->group(function () {
    Route::post('auth/mitra/logout', [MitraAuthController::class, 'logout']);
    Route::get('auth/mitra/me',      [MitraAuthController::class, 'me']);
    Route::post('auth/mitra/update-avatar', [MitraAuthController::class, 'updateAvatar']);
    Route::put('auth/mitra/update-location', [MitraAuthController::class, 'updateLocation']);

    Route::post('mitra/verification',        [MitraVerificationController::class, 'store']);
    Route::get('mitra/verification/status',  [MitraVerificationController::class, 'myStatus']);
    // Endpoint Riwayat Terpisah untuk Mitra
    Route::get('mitra/tasks/history', [TaskController::class, 'mitraHistory']); // <-- BARU: Riwayat kerja mitra

    // Tempat Mitra mencari lowongan tugas yang berstatus PENDING
    Route::get('mitra/tasks',              [TaskController::class, 'index']);      
    Route::get('mitra/tasks/{id}',         [TaskController::class, 'show']);       
    Route::post('mitra/tasks/{id}/accept', [TaskController::class, 'acceptTask']); 
    Route::post('mitra/tasks/{id}/rate-user', [TaskRatingController::class, 'rateUser']);
    Route::get('mitra/omzet', [OmzetController::class, 'mitraToday']);
    // Submit bukti pekerjaan
    Route::post('mitra/tasks/{id}/submit-proof',   [TaskController::class, 'submitProofOfWork']);

});
// ==========================================
// PROTECTED ROUTES FOR ADMIN (PENGELOLA SISTEM)
// ==========================================
Route::middleware('auth:admin')->group(function () {
    Route::post('auth/admin/logout', [AdminAuthController::class, 'logout']);
    Route::get('auth/admin/me',      [AdminAuthController::class, 'me']);

    // Manajemen Kategori Paket (Hanya Admin yang bisa Tambah, Edit, dan Hapus)
    Route::post('package-categories',        [PackageCategoryController::class, 'store']);
    Route::put('package-categories/{id}',       [PackageCategoryController::class, 'update']);
    Route::delete('package-categories/{id}',    [PackageCategoryController::class, 'destroy']);

    Route::post('job-categories',        [JobCategoryController::class, 'store']);
    Route::put('job-categories/{id}',       [JobCategoryController::class, 'update']);
    Route::delete('job-categories/{id}',    [JobCategoryController::class, 'destroy']);

    Route::get('admin/verifications',           [MitraVerificationController::class, 'index']);
    Route::get('admin/verifications/{id}',      [MitraVerificationController::class, 'show']);
    Route::put('admin/verifications/{id}/status', [MitraVerificationController::class, 'updateStatus']);

    Route::get('admin/omzet',         [OmzetController::class, 'index']);
    Route::get('admin/omzet/monthly', [OmzetController::class, 'monthly']);
});

// ==========================================
// PUBLIC MASTER DATA ROUTES
// ==========================================
// Tetap di luar middleware agar User/Mitra bisa panggil untuk dropdown atau list harga tanpa error 401
Route::get('package-categories',       [PackageCategoryController::class, 'index']);
Route::get('package-categories/{id}',  [PackageCategoryController::class, 'show']);

Route::get('job-categories',           [JobCategoryController::class, 'index']);
Route::get('job-categories/{id}',      [JobCategoryController::class, 'show']);

Route::get('/docs', function () {
    return view('api-docs');
}); 

Route::get('/file/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath)) abort(404);
    return response()->file($fullPath, [
        'Access-Control-Allow-Origin' => '*',
    ]);
})->where('path', '.*');