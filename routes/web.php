<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', function () {
    return view('home');
})->middleware('auth');

Route::get('login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('login', [AuthController::class, 'authenticate']);

Route::middleware('auth')->group(function() {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('dashboard', [DashboardController::class, 'index'])->middleware('admin');

    Route::get('users', [UserController::class, 'index'])->name('users.index')->middleware('admin');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');
    Route::post('users/update', [UserController::class, 'update'])->name('users.update');
    Route::get('users/edit/{id}/', [UserController::class, 'edit']);
    Route::get('users/destroy/{id}/', [UserController::class, 'destroy']);

    Route::get('buku', [BooksController::class, 'index'])->name('buku.index');
    Route::get('list-buku', [BooksController::class, 'GetDataBookUser'])->name('buku.GetDataBookUser');
    Route::post('buku/store', [BooksController::class, 'store'])->name('buku.store')->middleware('admin');
    Route::post('buku/update', [BooksController::class, 'update'])->name('buku.update')->middleware('admin');
    Route::get('buku/edit/{id}/', [BooksController::class, 'edit'])->middleware('admin');
    Route::get('buku/destroy/{id}/', [BooksController::class, 'destroy'])->middleware('admin');

    Route::get('data-peminjaman', [PeminjamController::class, 'index'])->name('data-peminjaman.index')->middleware('admin');
    Route::post('peminjam/store', [PeminjamController::class, 'store'])->name('peminjam.store');
    Route::post('peminjam/update', [PeminjamController::class, 'update'])->name('peminjam.update');
    Route::get('peminjam/edit/{id}/', [PeminjamController::class, 'edit'])->middleware('admin');
    Route::get('peminjam/destroy/{id}/', [PeminjamController::class, 'destroy']);

    // Route::get('data-peminjaman', [PeminjamController::class, 'index']);
    Route::get('peminjaman', [PeminjamController::class, 'getDataPeminjaman'])->name('store');
});


// api Books
Route::get('books', [BooksController::class, 'GetDataBook']);
Route::get('books/edit/{id}/', [BooksController::class, 'edit']);
Route::post('books/store', [BooksController::class, 'store']);
Route::put('books/update/{id}/', [BooksController::class, 'update']);
Route::delete('books/destroy/{id}/', [BooksController::class, 'destroy']);
