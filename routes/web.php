<?php

use Illuminate\Support\Facades\Http;
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
    return view('welcome');
    // $response = Http::get('https://jsonplaceholder.typicode.com/todos');
    // return Http::get('http://example.com');
    // $details['email'] = 'riazul.cse.mbstu@gmail.com';
    // dispatch(new App\Jobs\SendEmailJob($details));
    // dd('done');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/post-like',[App\Http\Controllers\HomeController::class, 'postLike']);

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});


Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('/csv_file', 'ExportImportController@index');
    Route::get('csv_file/export', 'ExportImportController@csv_export')->name('export');
    Route::post('csv_file/import', 'ExportImportController@csv_import')->name('import');


    Route::get('/uploader', 'VideoController@uploader')->name('uploader');
    Route::post('/upload', 'VideoController@store')->name('upload');
    Route::get('/chunk-video', 'VideoController@chunkVideo')->name('chunk.video');
    Route::post('/chunk-video-upload', 'VideoController@uploadLargeVideo')->name('chunk.video.upload');
});