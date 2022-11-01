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
    // return view('welcome');
    // $response = Http::get('https://jsonplaceholder.typicode.com/todos');
    // return Http::get('http://example.com');
    $details['email'] = 'riazul.cse.mbstu@gmail.com';
    dispatch(new App\Jobs\SendEmailJob($details));
    dd('done');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/post-like',[App\Http\Controllers\HomeController::class, 'postLike']);

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
