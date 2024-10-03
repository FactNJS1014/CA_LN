<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
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
    return view('main/index');
})->name('main');

Route::get('/second', function () {
    return view('main/contentfirst');
})->name('second');

Route::get('/fetch/tlog',[DataController::class,'FetchTLSLOG'])->name('get.tlog');
Route::get('/fetch/show',[DataController::class,'FetchshowTLSLOG'])->name('get.showtlog');

