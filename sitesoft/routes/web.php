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

Auth::routes();

Route::get('/reg-success', function () {
    return view('reg_success');
});


Route::get('/', 'Main@index')->name('index');
Route::middleware(['auth'])->post('/save', 'Main@save')->name('save');

