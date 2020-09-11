<?php


Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin', 'HomeController@administrator')->name('administrator');

Auth::routes();


// Show Ticket Create Form
Route::get('ticket/create', 'TicketsController@create')->name('ticket_create');
// Store New Ticket
Route::post('ticket/create', 'TicketsController@store')->name('ticket_store');
// Store Comment
Route::post('comment', 'CommentsController@storeComment')->name('create comment');
// Show a Ticket
Route::get('tickets/{ticket_id}', 'TicketsController@show')->name('ticket_show');

Route::group(['middleware' => 'auth'], function() {
    // list tickets.
    Route::get('tickets', 'TicketsController@index');
    // Get tickets assigned to an agent
    Route::get('tickets/assigned/{id}', 'TicketsController@getAgentTickets');
    // Show Ticket Collection On Current User (Authenticated)
    Route::get('tickets', 'TicketsController@showByCurrentUser')->name('tickets_show');
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
    Route::get('tickets', 'TicketsController@index')->name('tickets');
    Route::post('tickets/close/{ticket_id}', 'TicketsController@close')->name('close');
    Route::get('tickets/edit/{ticket_id}', 'TicketsController@edit')->name('edit');
    Route::post('tickets/update', 'TicketsController@update')->name('update');
    Route::post('tickets/remove/{ticket_id}', 'TicketsController@destroy')->name('destroy');
});