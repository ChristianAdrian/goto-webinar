<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\WebinarList;
use App\Http\Controllers\GoToWebinarController;
use App\Http\Middleware\EnsureTokenIsValid;

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

Route::get('/list',WebinarList::class)->middleware(EnsureTokenIsValid::class);
Route::get('/',[GoToWebinarController::class, 'home'])->middleware(EnsureTokenIsValid::class);
Route::get('/getToken',[GoToWebinarController::class, 'generateToken']);
Route::get('/generateCode',[GoToWebinarController::class, 'generateCode']);
Route::get('/saveToken',[GoToWebinarController::class, 'saveToken']);

Route::get('/createWebinar',[GoToWebinarController::class, 'createWebinar']);
Route::get('/getWebinarList',[GoToWebinarController::class, 'getWebinarList']);
