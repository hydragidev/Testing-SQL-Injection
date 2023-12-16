<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [Dashboard::class, 'dashboard'])->name('dashboard.index');
Route::get('/dashboard/add', [Dashboard::class, 'add_project'])->name('dashboard.add_project');
Route::post('/dashboard/add', [Dashboard::class, 'process_add_project'])->name('dashboard.process_add_project');
Route::get('/dashboard/delete/{id}', [Dashboard::class, 'delete_project'])->name('dashboard.delete_project');
Route::get('/dashboard/reset_project', [Dashboard::class, 'reset_project'])->name('dashboard.reset_project');
