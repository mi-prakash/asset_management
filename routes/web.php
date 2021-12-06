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

    // Users
    Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'getUsers'])->name('admin.getUsers');
    Route::get('/admin/users/add', [App\Http\Controllers\AdminController::class, 'addUser'])->name('admin.addUser');
    Route::post('/admin/users/store', [App\Http\Controllers\AdminController::class, 'storeUser'])->name('admin.storeUser');
    Route::get('/admin/users/edit/{id}', [App\Http\Controllers\AdminController::class, 'editUser'])->name('admin.editUser');
    Route::post('/admin/users/update/{id}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin.updateUser');
    Route::delete('/admin/users/destroy/{id}', [App\Http\Controllers\AdminController::class, 'destroyUser'])->name('admin.destroyUser');

    // Assets
    Route::get('/admin/assets', [App\Http\Controllers\AssetController::class, 'index'])->name('admin.assets.index');
    Route::get('/admin/assets/add', [App\Http\Controllers\AssetController::class, 'add'])->name('admin.assets.add');
    Route::post('/admin/assets/store', [App\Http\Controllers\AssetController::class, 'store'])->name('admin.assets.store');
    Route::get('/admin/assets/edit/{id}', [App\Http\Controllers\AssetController::class, 'edit'])->name('admin.assets.edit');
    Route::post('/admin/assets/update/{id}', [App\Http\Controllers\AssetController::class, 'update'])->name('admin.assets.update');
    Route::delete('/admin/assets/destroy/{id}', [App\Http\Controllers\AssetController::class, 'destroy'])->name('admin.assets.destroy');

    // Assign Assets
    Route::get('/admin/assign_assets', [App\Http\Controllers\AssetController::class, 'assignAssetsIndex'])->name('admin.assets.assignAssetsIndex');
    Route::get('/admin/assign_assets/{id}', [App\Http\Controllers\AssetController::class, 'assignAssetsAdd'])->name('admin.assets.assignAssetsAdd');
    Route::post('/admin/assign_assets/{id}', [App\Http\Controllers\AssetController::class, 'assignAssetsUpdate'])->name('admin.assets.assignAssetsUpdate');
    Route::post('/admin/assign_assets/destroy/{id}', [App\Http\Controllers\AssetController::class, 'assignAssetsDestroy'])->name('admin.assets.assignAssetsDestroy');

    Route::get('/admin/assigned_assets', [App\Http\Controllers\AssetController::class, 'assignedAssetsList'])->name('admin.assets.assignedAssetsList');

    Route::get('/admin/test_mail', [App\Http\Controllers\AssetController::class, 'testMail'])->name('admin.assets.testMail');
});
