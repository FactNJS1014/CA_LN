<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\InsertController;
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
    return view('main/caseandactive');
})->name('second');

Route::get('/third', function () {
    return view('main/showrecord');
})->name('third');

//Method GET
Route::get('/fetch/tlog',[DataController::class,'FetchTLSLOG'])->name('get.tlog');
Route::get('/fetch/show',[DataController::class,'FetchshowTLSLOG'])->name('get.showtlog');
Route::get('/fetch/datarec',[DataController::class,'getDataFormFirst'])->name('get.datarec');
Route::get('/show/data',[DataController::class,'ShowRecord'])->name('show.data');
Route::get('/show/edit',[DataController::class,'ShoweditRecord'])->name('show.edit');

//Method GET to Delete Data Record
Route::get('/delete',[InsertController::class,'DeleteRecord'])->name('delete.data');

//Method POST
// Route::post('/fetch/search',[DataController::class,'SearchTLSLOG'])->name('post.searchtlog');
// Route::post('/fetch/update',[DataController::class,'UpdateTLSLOG'])->name('post.updatetlog');
// Route::post('/fetch/delete',[DataController::class,'DeleteTLSLOG'])->name('post.deletetlog');
Route::post('/fetch/insertcase',[InsertController::class,'AddCaseandActive'])->name('post.addcase');
Route::post('/fetch/add',[InsertController::class,'AddTLSLOG'])->name('post.addtlog');
Route::post('/update/form',[InsertController::class,'UpdateForm'])->name('update.form');

?>


