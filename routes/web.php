<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

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

Auth::routes();

Route::resource('addrecipe', CategoryController::class);

Route::get('home', [CategoryController::class, 'index'])->name('home');
Route::get('list', [CategoryController::class, 'list'])->name('home');
Route::get('export', [CategoryController::class, 'exportCsv']);
