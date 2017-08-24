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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'wechat', 'namespace' => 'Wechat'], function () {
    Route::get('activity/{activity}/index', 'QuestionController@index')->name('index');

    Route::get('question/{question}/answer', 'QuestionController@answer')->name('answer');

    Route::post('question/{question}/answer', 'QuestionController@change')->name('question');

    Route::get('test/{test}/answer', 'QuestionController@grade')->name('test');

    Route::get('rules/{activity}', 'PublicController@rules')->name('rules');

    Route::get('activity/{activity}/turntable', 'TurntableController@index')->name('turntable');

    Route::post('activity/{activity}/turntable', 'TurntableController@store');

    Route::get('activity/{activity}/award', 'TurntableController@award')->name('award');
});
