<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;





Route::prefix('auth')->group(function(){                
    Route::controller(AuthController::class)->group(function(){
        Route::get('login','login')->name('login');
        Route::get('register','register');
        Route::get('logout','logout');
        Route::post('store','store');
        Route::post('registerstore','registerstore');
    });                    
}); 

Route::middleware(['auth'])->group(function () {

    Route::controller(TaskController::class)->group(function(){
        Route::get('/','index');
        Route::get('destroy/{id}','destroy');
        Route::post('store','store');
        Route::post('update','update');
        Route::post('assigntask','assigntask');
    });
});
    