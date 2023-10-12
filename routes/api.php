<?php

use App\Http\Controllers\API\authUserAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DriveController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('user')->group(function(){
    Route::post('register' ,[authUserAPIController::class , 'register']);
    Route::post('login' ,[authUserAPIController::class , 'login']);
});

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('drive')->group(function(){
        Route::get('index' , [DriveController::class , 'index'])->name('drive.index');
        Route::post('store' , [DriveController::class , 'store'])->name('drive.store');
        Route::get('yourFiles' , [DriveController::class , 'UserFiles'])->name('drive.userfiles');
        Route::get('listUserFiles/{id}' , [DriveController::class , 'listUserFiles'])->name('drive.listUserFiles');

        // admin only can view the next route
        // Route::get('allFiles' , [DriveController::class , 'allFiles'])->name('drive.allFiles')->middleware('admin');
        Route::get('allFiles' , [DriveController::class , 'allFiles'])->name('drive.allFiles');

        // routes with id

        Route::post("update/{id}" , [DriveController::class , 'update'])->name("drive.update");
        Route::get("show/{id}" , [DriveController::class , 'show'])->name("drive.show");
        Route::get("download/{id}" , [DriveController::class , 'download'])->name("drive.download");
        Route::delete("destroy/{id}" , [DriveController::class , 'destroy'])->name("drive.destroy");
        Route::get("changeStatus/{id}" , [DriveController::class , 'changeStatus'])->name("drive.changeStatus");
    });
    Route::get('logout' ,[authUserAPIController::class , 'logout']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
