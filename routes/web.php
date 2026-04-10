<?php

use Illuminate\Support\Facades\Route;

// CONTROLLER
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;

// ADMIN
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LogAktivitasController;
use App\Http\Controllers\Admin\PlayStationController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Admin\RoleController;

// PETUGAS
use App\Http\Controllers\Petugas\PeminjamanController;

// USER
use App\Http\Controllers\User\ProductController;


/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', [ProductController::class, 'index'])->name('landing');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])
    ->whereNumber('id')
    ->name('products.show');


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('register.store');


/*
|--------------------------------------------------------------------------
| USER LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::view('/profile', 'profile.index')->name('profile');

    Route::get('/notif/read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    })->name('notif.read');
});


/*
|--------------------------------------------------------------------------
| USER AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/sewa/riwayat', [ProductController::class, 'riwayat'])->name('sewa.riwayat');

    Route::get('/sewa/{id}', [ProductController::class, 'create'])->name('sewa.create');
    Route::post('/sewa', [ProductController::class, 'store'])->name('sewa.store');

    Route::delete('/sewa/cancel/{id}', [ProductController::class, 'cancel'])->name('sewa.cancel');

    Route::get('/sewa/kembali/{id}', [ProductController::class, 'formKembali'])->name('sewa.form.kembali');
    Route::post('/sewa/kembali/{id}', [ProductController::class, 'kembali'])->name('sewa.kembali');

    Route::get('/sewa/struk/{id}', [ProductController::class, 'struk'])->name('sewa.struk');
});


/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // MASTER
        Route::resource('categories', CategoryController::class)->except(['create', 'show']);
        Route::resource('playstation', PlayStationController::class)->except(['show']);

        // USERS
        Route::resource('users', UsersController::class);

        // ROLES
        Route::get('/roles', [RoleController::class, 'index'])->name('roles');

        // PEMINJAMAN
        Route::resource('peminjaman', AdminPeminjamanController::class)
            ->except(['create', 'store']);

        // PENGEMBALIAN
        Route::get('/pengembalian', [AdminPeminjamanController::class, 'pengembalian'])
            ->name('pengembalian');

        // KONFIRMASI
        Route::get('/peminjaman/konfirmasi/{id}', [AdminPeminjamanController::class, 'konfirmasi'])
            ->name('peminjaman.konfirmasi');

        // ✅ FIX LOG AKTIVITAS (TARUH DI SINI)
        Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])
            ->name('log-aktivitas.index');
    });


/*
|--------------------------------------------------------------------------
| PETUGAS AREA
|--------------------------------------------------------------------------
*/
Route::prefix('petugas')
    ->middleware(['auth', 'role:petugas'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('petugas.dashboard');

        Route::get('/peminjaman', [PeminjamanController::class, 'index'])
            ->name('petugas.peminjaman.index');

        Route::post('/peminjaman/{id}/setujui', [PeminjamanController::class, 'setujui'])
            ->name('petugas.peminjaman.setujui');

        Route::post('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])
            ->name('petugas.peminjaman.tolak');

        Route::post('/peminjaman/{id}/serahkan', [PeminjamanController::class, 'serahkan'])
            ->name('petugas.peminjaman.serahkan');

        Route::post('/peminjaman/{id}/selesai', [PeminjamanController::class, 'selesai'])
            ->name('petugas.peminjaman.selesai');

        Route::get('/pengembalian', [PeminjamanController::class, 'pengembalian'])
            ->name('petugas.pengembalian.index');

        Route::get('/peminjaman/cetak/{id}', [PeminjamanController::class, 'cetakSatu'])
            ->name('petugas.peminjaman.cetak');
    });
