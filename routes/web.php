<?php

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
Route::get('/users/{userId}', function ($userId) {
    $user = DB::table('users')->whereId($userId)->first();
    $data = DB::table('users')->where('registeredBy', $userId)->get(['name', 'phone', 'email']);

    $date_to = Carbon::now()->format('Y-m-d H:i:s');
    $date_from = Carbon::now()->subDays(14)->format('Y-m-d H:i:s');

    $users = DB::table('users')->select(DB::raw("COUNT(*) as count"), DB::raw("DAYNAME(created_at) as day_name"))
        ->where('registeredBy', $userId)
        ->where('created_at', '>=', $date_from)
        ->where('created_at', '<=', $date_to)
        ->groupBy(DB::raw("DAYNAME(created_at)"))
        ->pluck('count', 'day_name');
    $labels = $users->keys();
    $chartData = $users->values();

    return view('users', compact('user', 'data', 'labels', 'chartData'));
});
Route::post('/login', [UserController::class, 'login']);
Route::post('/signUp', [UserController::class, 'signUp']);
Route::get('/incrementVisit/{registeredBy}', [UserController::class, 'incrementVisit']);

Route::get('/admin', function () {
    $users = DB::table('users')->get();
    return view('admin', compact('users'));
});
