<?php

use Illuminate\Support\Facades\Route;
// 日報管理用controller
use App\Http\Controllers\ReportController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::redirect('/', '/dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/dailyreport', function () {
    return Inertia\Inertia::render('Dailyreport');
})->name('dailyreport');

Route::middleware(['auth:sanctum', 'verified'])->get('/design', function () {
    return Inertia\Inertia::render('Design');
})->name('design');

Route::middleware(['auth:sanctum', 'verified'])->get('/task', function () {
    return Inertia\Inertia::render('Task');
})->name('task');


Route::resource('posts', ReportController::class);
