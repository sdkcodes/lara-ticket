<?php

Route::namespace("Sdkcodes\LaraTicket\Controllers")->middleware('web', 'auth')->group(function(){

	Route::get('admin/tickets', "TicketController@index");
	Route::get('tickets/create', "TicketController@create");
	Route::get('tickets/{status?}', "TicketController@index");
	Route::get('tickets/show/{ticket}', "TicketController@show");
	Route::get('tickets/{ticket}/update', "TicketController@changestatus");
	Route::post('tickets/store', "TicketController@store");
	Route::put('tickets/{ticket}', "TicketController@update");
	Route::delete('tickets/{ticket}', "TicketController@delete");

	Route::post('tickets/comments/store/{ticket}', "TicketController@reply");

	Route::get('admin/tickets/options/settings', "TicketOptionController@options");
	Route::post('admin/tickets/options/settings', "TicketOptionController@store");
	Route::put('admin/tickets/options/settings', "TicketOptionController@update");
});
