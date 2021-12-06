<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::group(['middleware' => ['user']], function()
{
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});

/*Admin routes*/
Route::group(['middleware' => 'admin'], function()
{
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'getUsers'])->name('admin.getUsers');
    Route::get('/admin/users/add', [App\Http\Controllers\AdminController::class, 'addUser'])->name('admin.addUser');
    Route::post('/admin/users/store', [App\Http\Controllers\AdminController::class, 'storeUser'])->name('admin.storeUser');
    Route::get('/admin/users/edit/{id}', [App\Http\Controllers\AdminController::class, 'editUser'])->name('admin.editUser');
    Route::post('/admin/users/update/{id}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.updateUser');
    Route::delete('/admin/users/destroy/{id}', [App\Http\Controllers\AdminController::class, 'destroyUser'])->name('admin.destroyUser');

});
