<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketsController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

//Route::get('/', 'HomeController@index');
Route::get('/home', 'App\Http\Controllers\TicketsController@index')->name('home');

Route::get('/new_ticket', 'App\Http\Controllers\TicketsController@create')->name('new_ticket');
Route::post('/new_ticket', 'App\Http\Controllers\TicketsController@store')->name('new_ticket'); 

Route::get('/tickets/{ticket_id}', 'App\Http\Controllers\TicketsController@show');
Route::get('/user_tickets', 'App\Http\Controllers\TicketsController@userTickets');

Route::post('/comment', 'App\Http\Controllers\CommentsController@postComment');

//Route::post('close_ticket/{ticket_id}', 'App\Http\Controllers\TicketsController@close');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
    Route::get('tickets', 'App\Http\Controllers\TicketsController@index');
    Route::post('close_ticket/{ticket_id}', 'App\Http\Controllers\TicketsController@close');
});


