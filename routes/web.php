<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\MovieController;

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

Route::get('/', [WelcomeController::class,'index'])->name('welcome');

Auth::routes();

Route::post('/movies/{movie}/increment_views', [MovieController::class,'increment_views'])->name('movies.increment_views');
Route::post('/movies/{movie}/toggle_favorite', [MovieController::class,'toggle_favorite'])->name('movies.toggle_favorite');


Route::resource('movies', 'MovieController')->only(['index','show']);

