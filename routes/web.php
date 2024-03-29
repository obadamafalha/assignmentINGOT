<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::post('/login', [UserController::class, 'login']);
Route::post('/signUp', [UserController::class, 'signUp']);


Route::get('/users/{userId}', [UserController::class, 'userPage']);

Route::get('/incrementVisit/{registeredBy}', [UserController::class, 'incrementVisit']);

Route::get('/admin', [AdminController::class, 'adminPage']);
Route::get('/userTree/{user}', [UserController::class, 'userTree']);
