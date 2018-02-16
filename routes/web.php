<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    // Role User
    Route::get('/home', 'HomeController@index')->name('home');

    // Role Admin
    Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'role:Admin'], function() {
        Route::get('/', 'DashboardController@index')->name('dashboard.index');
        Route::resource('/user', 'UserController');
        Route::resource('/category', 'CategoryController');

        // DataTable
        Route::get('/data-table/user', 'DataTableController@user')->name('data_table.user');
        Route::get('/data-table/category', 'DataTableController@category')->name('data_table.category');
    });

});
