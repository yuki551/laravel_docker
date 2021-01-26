<?php

use Illuminate\Support\Facades\Route;
// dashboard controller
use App\Http\Controllers\HomeController;
// 日報管理用controller
use App\Http\Controllers\PostController;
// 日報一覧表示controller
use App\Http\Controllers\PostListController;
use App\Http\Controllers\MyPostListController;
// 社員一覧表示controller
use App\Http\Controllers\UserListController;
// 顧客一覧表示controller
use App\Http\Controllers\ClientListController;
// 顧客登録
use App\Http\Controllers\ClientCreateController;
// 社員登録
use App\Http\Controllers\EmployeeCreateController;

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

Route::resource('/postlists', PostListController::class);
Route::resource('/mypostlists', MyPostListController::class);

Route::resource('/userlists', UserListController::class);
Route::resource('/clientlists', ClientListController::class);
Route::resource('/clients_create', ClientCreateController::class);

Route::resource('/employee_create', EmployeeCreateController::class);
