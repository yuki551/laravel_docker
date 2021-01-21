<?php

use Illuminate\Support\Facades\Route;
// dashboard controller
use App\Http\Controllers\HomeController;
// 日報管理用controller
use App\Http\Controllers\PostController;

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
    return view('login');
});

Route::redirect('/', 'dashboard');

Route::resource('dashboard', HomeController::class);
// 日報管理用controllerへroute
Route::resource('posts', PostController::class);

Route::resource('admin', AdminController::class);
