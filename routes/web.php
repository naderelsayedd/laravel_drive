<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DriveController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes([
    'verify' =>true
]);

Route::middleware('auth' , 'verified')->group(function(){
    // drive routes
Route::prefix('drive')->group(function(){
    Route::get('index' , [DriveController::class , 'index'])->name('drive.index');
    Route::get('create' , [DriveController::class , 'create'])->name('drive.create');
    Route::post('create' , [DriveController::class , 'store'])->name('drive.store');
    Route::get('yourFiles' , [DriveController::class , 'UserFiles'])->name('drive.userfiles');

    // admin only can view the next route
    Route::get('allFiles' , [DriveController::class , 'allFiles'])->name('drive.allFiles')->middleware('admin');

    // routes with id

    Route::get("edit/{id}" , [DriveController::class , 'edit'])->name("drive.edit");
    Route::post("edit/{id}" , [DriveController::class , 'update'])->name("drive.update");
    Route::get("show/{id}" , [DriveController::class , 'show'])->name("drive.show");
    Route::get("download/{id}" , [DriveController::class , 'download'])->name("drive.download");
    Route::get("destroy/{id}" , [DriveController::class , 'destroy'])->name("drive.destroy");
    Route::get("changeStatus/{id}" , [DriveController::class , 'changeStatus'])->name("drive.changeStatus");

});
});

Route::prefix('user')->group(function(){
    Route::get('index' , [UserController::class , 'index'])->name('user.index')->middleware('admin');
});
