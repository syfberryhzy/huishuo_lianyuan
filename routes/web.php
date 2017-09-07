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
Route::get('/', function() {
	echo "请在分好啦公众号打开";exit;
});
Route::group(['prefix' => 'wechat/activity/{activity}', 'namespace' => 'Wechat'], function () {
    Route::get('openid/{openid}', 'QuestionController@index')->name('index');

    Route::get('question/{question}/answer', 'QuestionController@answer')->name('answer');

    Route::post('question/{question}/answer', 'QuestionController@change')->name('question');

    Route::get('test/{test}/answer', 'QuestionController@grade')->name('test');

    Route::get('rules', 'PublicController@rules')->name('rules');

    Route::get('answer/{answer}/turntable', 'TurntableController@index')->name('turntable');

    Route::post('question/{question}/turntable', 'TurntableController@store');

    Route::post('lottery/{lottery}', 'TurntableController@convert');

    Route::get('award', 'TurntableController@award')->name('award');

    Route::get('redirect', 'PublicController@redirect')->name('redirect');
});
