<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')
    ->name('dashboard.')
    ->middleware(['auth','role:super_admin|admin'])
    ->group(function (){
        //welcome routes
        Route::get('/',[welcomeController::class,'index'])->name('welcome');
        //categories routes
        Route::resource('categories','CategoryController')->except(['show']);

        //roles routes
        Route::resource('roles', 'RoleController')->except(['show']);

        //users routes
        Route::resource('users', 'UserController');

        //users routes
        Route::resource('movies', 'MovieController');

});
