<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
// admin controller
use App\Http\Controllers\AdminController;
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
// 社員編集
use App\Http\Controllers\EmployeeEditController;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\UserConfirmController;

// 部署
use App\Http\Controllers\TeamListController;

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
// Route::resource('posts', PostController::class);


Route::resource('admin', AdminController::class);

Route::resource('/postlists', PostListController::class);
Route::resource('/mypostlists', MyPostListController::class);

Route::resource('/userlists', UserListController::class);

Route::resource('/clientlists', ClientListController::class);
Route::resource('/clients_create', ClientCreateController::class);

Route::resource('/employee_create', EmployeeCreateController::class);
// Route::resource('/employee_edit', EmployeeEditController::class);
// Route::post('/employee_edit', [EmployeeEditController::class, 'post']);

// Route::resource('/users/confirm', UserConfirmController::class);


Route::get('/posts', [PostController::class, 'index'])
    ->name('post.index');
Route::get('/posts/create', [PostController::class, 'create'])
    ->name('post.create');
Route::post('/posts', [PostController::class, 'store'])
    ->name('post.store');
Route::put('/posts/{post}', [PostController::class, 'update'])
    ->name('post.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])
    ->name('post.destroy');
Route::post('/posts/confirm', [PostController::class, 'confirm'])
    ->name('post.confirm');
Route::get('/posts/confirm', [PostController::class, 'getconfirm'])
    ->name('post.getconfirm');

Route::get('/users', [UserController::class, 'index'])
    ->name('user.index');
Route::get('/users/create', [UserController::class, 'create'])
    ->name('user.create');
Route::post('/users', [UserController::class, 'store'])
    ->name('user.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])
    ->name('user.edit');
Route::put('/users/{user}', [UserController::class, 'update'])
    ->name('user.update');
Route::get('/users/{user}', [UserController::class, 'show'])
    ->name('user.show');
Route::delete('/users/{user}', [UserController::class, 'destroy'])
    ->name('user.destroy');
Route::post('/users/confirm', [UserController::class, 'confirm'])
    ->name('user.confirm');



Route::get('/teamlists', [TeamListController::class, 'index'])
    ->name('teamlist.index');
Route::get('/teamlists/create', [TeamListController::class, 'create'])
    ->name('teamlist.create');
Route::post('/teamlists', [TeamListController::class, 'store'])
    ->name('teamlist.store');
Route::get('/teamlists/{teamlist}/edit', [TeamListController::class, 'edit'])
    ->name('teamlist.edit');
Route::put('/teamlists/{teamlist}', [TeamListController::class, 'update'])
    ->name('teamlist.update');
Route::get('/teamlists/{teamlist}', [TeamListController::class, 'show'])
    ->name('teamlist.show');
Route::delete('/teamlists/{teamlist}', [TeamListController::class, 'destroy'])
    ->name('teamlist.destroy');
Route::post('/teamlists/confirm', [TeamListController::class, 'confirm'])
    ->name('teamlist.confirm');
