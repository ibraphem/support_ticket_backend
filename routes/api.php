<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login', 'api\AuthController@login')->name('login.api');
    Route::post('/register', 'api\AuthController@register')->name('register.api');
    Route::get('agents', "api\AuthController@fetchAgents");

    Route::post('save/ticket', 'api\TicketController@store');
    Route::get('view/ticket/{user_id}', "api\TicketController@index");
    Route::get('tickets/admin', "api\TicketController@admin");
    Route::get('agent/{user_id}', "api\TicketController@agent");
    Route::get('assign/ticket/{agent_id}/{ticket_id}', "api\TicketController@update");
    Route::get('detail/{ticket_id}/{file_id}', "api\TicketController@ticketDetail");
    Route::get('status/{ticketID}/{statusValue}', "api\TicketController@ticketStatus");
    
    
    Route::post('save/reply', 'api\ReplyController@store');
    Route::get('test', "api\ReplyController@test");
});
