<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Import Controller Admin
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\ManajemenUserController;
use App\Http\Controllers\Admin\VerifikasiDokumenController;
use App\Http\Controllers\Admin\DataArsipController;
use App\Http\Controllers\Admin\LaporanAdminController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\DepartemenController;

// Import Controller Karyawan
use App\Http\Controllers\Karyawan\DashboardKaryawanController;
use App\Http\Controllers\Karyawan\UploadDokumenController;
use App\Http\Controllers\Karyawan\KotakMasukController;

// Import Controller Pimpinan
use App\Http\Controllers\Pimpinan\DashboardPimpinanController;
use App\Http\Controllers\Pimpinan\LaporanPimpinanController;
use App\Http\Controllers\Karyawan\EmailPusatController;
use App\Http\Controllers\Karyawan\GmailAuthController;
use App\Http\Controllers\Karyawan\ArsipUtamaController;
use App\Http\Controllers\Pimpinan\SuratDisposisiController;
use App\Http\Controllers\Admin\LogAktivitasController;

use Illuminate\Support\Facades\Schedule;

Route::get('/', function () {
    return view('welcome');
});
Schedule::command('email:tarik')->everyMinute();

Route::post('/auth/google/disconnect', [GmailAuthController::class, 'disconnect'])->name('google.disconnect');
Route::get('/inbox-pusat/sync', [EmailPusatController::class, 'syncGmail'])->name('karyawan.email.sync');
Route::get('/auth/google/callback', [GmailAuthController::class, 'callback'])->name('google.callback');

Route::get('/dokumen/{id}/download', [App\Http\Controllers\DownloadController::class, 'unduh'])
    ->name('dokumen.download')
    ->middleware('auth');
// Profile Routes bawaan Laravel Breeze
Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');

    // Verifikasi Dokumen
    Route::get('/verifikasi', [VerifikasiDokumenController::class, 'index'])->name('verifikasi.index');
    Route::post('/verifikasi/{id}', [VerifikasiDokumenController::class, 'store'])->name('verifikasi.store');

    // Laporan
    Route::get('/laporan', [LaporanAdminController::class, 'index'])->name('laporan.index');

    // Resource Routes (Otomatis membuat rute index, create, store, edit, update, destroy)
    Route::resource('users', ManajemenUserController::class);
    Route::resource('arsip', DataArsipController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('departemen', DepartemenController::class);

    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log.index');
});

/*
|--------------------------------------------------------------------------
| ROUTE KARYAWAN / STAFF
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Staff'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', [DashboardKaryawanController::class, 'index'])->name('dashboard');

    // Kotak Masuk Disposisi
    Route::get('/inbox', [KotakMasukController::class, 'index'])->name('inbox.index');

    // Upload Dokumen & Status
    Route::resource('dokumen', UploadDokumenController::class);

    // Rute untuk Fitur Inbox Email Pusat (Mini Gmail)
    Route::get('/inbox-pusat', [EmailPusatController::class, 'index'])->name('email.index');
    Route::post('/inbox-pusat/pengaturan', [EmailPusatController::class, 'simpanPengaturan'])->name('email.pengaturan');
    Route::get('/inbox-pusat/{id}', [EmailPusatController::class, 'baca'])->name('email.baca');
    Route::post('/inbox-pusat/arsipkan/{id}', [EmailPusatController::class, 'arsipkan'])->name('email.arsipkan');

// Fitur Staff melihat Arsip Utama (Hanya Read/Download)
    Route::get('/arsip-utama', [ArsipUtamaController::class, 'index'])->name('arsip.index');
    
    // Fitur Kotak Masuk dari Pimpinan (Mungkin rute ini sudah ada, kita pastikan saja)
    Route::get('/inbox', [KotakMasukController::class, 'index'])->name('inbox.index');
    // Rute Otentikasi Gmail
    Route::get('/auth/google', [GmailAuthController::class, 'redirect'])->name('google.redirect');
});

/*
|--------------------------------------------------------------------------
| ROUTE PIMPINAN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Pimpinan'])->prefix('pimpinan')->name('pimpinan.')->group(function () {
    Route::get('/dashboard', [DashboardPimpinanController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [LaporanPimpinanController::class, 'index'])->name('laporan.index');
// Rute untuk Kelola Arsip Utama (Pimpinan)
    Route::resource('arsip', App\Http\Controllers\Pimpinan\DataArsipController::class);
    // Ganti rute manual sebelumnya menjadi Resource (Otomatis Full CRUD)
    Route::resource('surat', SuratDisposisiController::class);
});

require __DIR__ . '/auth.php';
