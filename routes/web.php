<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\InsertController;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ApprController;
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

Route::get('/Report', function () {
    return view('main/ReportData');
})->name('four');

Route::get('/table-data', function () {
    return view('main/table');
})->name('table');

//Method GET
Route::get('/fetch/tlog',[DataController::class,'FetchTLSLOG'])->name('get.tlog');
Route::get('/fetch/show',[DataController::class,'FetchshowTLSLOG'])->name('get.showtlog');
Route::get('/fetch/datarec',[DataController::class,'getDataFormFirst'])->name('get.datarec');
Route::get('/show/data',[DataController::class,'ShowRecord'])->name('show.data');
Route::get('/show/edit',[DataController::class,'ShoweditRecord'])->name('show.edit');
Route::get('/show/report',[DataController::class,'ShowReports'])->name('show.report');
Route::get('/show/data5',[DataController::class,'ShowData']);


//Method GET to Delete Data Record
Route::get('/delete',[InsertController::class,'DeleteRecord'])->name('delete.data');
Route::get('/delete/img',[InsertController::class,'DeleteImage'])->name('delete.img');

//Method POST
// Route::post('/fetch/search',[DataController::class,'SearchTLSLOG'])->name('post.searchtlog');
// Route::post('/fetch/update',[DataController::class,'UpdateTLSLOG'])->name('post.updatetlog');
// Route::post('/fetch/delete',[DataController::class,'DeleteTLSLOG'])->name('post.deletetlog');
Route::post('/fetch/insertcase',[InsertController::class,'AddCaseandActive'])->name('post.addcase');
Route::post('/fetch/add',[InsertController::class,'AddTLSLOG'])->name('post.addtlog');
Route::post('/update/form',[InsertController::class,'UpdateForm'])->name('update.form');
Route::post('/update/reject',[InsertController::class,'UpdateforReject'])->name('update.reject');

//Use PDF
Route::get('/generate-pdf', [PDFController::class, 'generatePDF'])->name('generate.pdf');

//Use Approval
Route::get('/approve', [ ApprController::class, 'getAppr'])->name('approve.next');
Route::get('/insert/approve', [ ApprController::class, 'InsertAppr'])->name('ins.appr');

//Use Reject
Route::post('/insert/reject', [ ApprController::class, 'InsertReject'])->name('reject.data');

//Send Mail Notification
Route::get('/send-email', [DataController::class, 'SendEmail'])->name('send.email');

//Send Mail to Input Case and Active
Route::get('/send-email-input', [DataController::class, 'SendMailToInput'])->name('send.input');

?>


