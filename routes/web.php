<?php

use App\Http\Controllers\InvoiceController;
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
    //go to login page if you find /
    return view('auth.login');
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/invoices', 'InvoiceController');

Route::resource('/sections', 'SectionsController');

Route::get('/{page}', 'AdminController@index');



