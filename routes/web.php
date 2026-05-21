<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\KontenController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PendaftaranAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftaranController;
use App\Services\ApiClient;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function (ApiClient $api) {
    $content = [];

    try {
        $response = $api->get('/api/site-content');
        if ($response->status() >= 200 && $response->status() < 300) {
            $content = $response->json('data') ?? [];
        }
    } catch (\Throwable $e) {
    }

    return view('welcome', compact('content'));
});

Route::get('/pendaftaran', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');

Route::get('/loginadmin', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/loginadmin', [AuthController::class, 'login']);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/konten', [KontenController::class, 'index'])->name('konten.index');
    Route::post('/konten', [KontenController::class, 'update'])->name('konten.update');

    Route::get('/pendaftar', [PendaftaranAdminController::class, 'index'])->name('pendaftar.index');
    Route::post('/pendaftar/bulk', [PendaftaranAdminController::class, 'bulk'])->name('pendaftar.bulk');
    Route::get('/pendaftar/{id}', [PendaftaranAdminController::class, 'show'])->name('pendaftar.show');
    Route::post('/pendaftar/{id}/status', [PendaftaranAdminController::class, 'updateStatus'])->name('pendaftar.updateStatus');
    Route::post('/pendaftar/{id}/hapus', [PendaftaranAdminController::class, 'destroy'])->name('pendaftar.destroy');

    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::post('/jadwal/bulk-hapus', [JadwalController::class, 'bulkDestroy'])->name('jadwal.bulkDestroy');
    Route::post('/jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::post('/jadwal/{id}/hapus', [JadwalController::class, 'destroy'])->name('jadwal.destroy');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

Route::post('/logout', function () {
    Session::forget(['api_token', 'admin_name', 'admin_email']);

    return redirect('/');
});
