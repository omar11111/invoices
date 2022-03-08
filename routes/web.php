<?php

// use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\invoice_details;
use Illuminate\Support\Facades\Auth;

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
// Route::resource('/invoices', 'InvoiceController');
route::resource('/invoices',InvoiceController::class);
route::resource('/invoices_details',InvoiceDetailsController::class);
Route::get('download/{invoice_number}/{file_name}', 'InvoiceDetailsController@get_file');

Route::get('View_file/{invoice_number}/{file_name}', 'InvoiceDetailsController@open_file');

Route::post('delete_file', 'InvoiceDetailsController@destroy')->name('delete_file');

Route::resource('/sections', 'SectionsController');
// Route::get('/invoice-products/{id}',[InvoiceController::class ,'getProducts'])->name('invoice-products');
 Route::get('/section/{id}', 'InvoiceController@getProducts');
//  Route::get('step/{id}',[Frontend\OrderDetailController::class , 'showstep'])->name('step'); //go to trackstep from order details page
Route::resource('/products', 'ProductController');
Route::get('/{page}', 'AdminController@index');


