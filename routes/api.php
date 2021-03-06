<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('API')->group(function () {

    Route::apiResources([
        'orders' => 'OrderController',
        'messages' => 'MessageController'
    ]);

    Route::get('/last-sent-messages', 'MessageController@lastSentMessages')->name('messages.last_sent_messages');

});
