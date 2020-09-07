<?php


Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();


// Show Ticket Create Form
Route::get('ticket/create', 'TicketsController@create')->name('ticket_create');

// Store New Ticket
Route::post('ticket/create', 'TicketsController@store')->name('ticket_store');

// Show a Ticket
Route::get('tickets/{ticket_id}', 'TicketsController@show')->name('ticket_show');

// Show Ticket Collection On Current User (Authenticated)
Route::get('tickets', 'TicketsController@showByCurrentUser')->name('tickets_show');

// Store Comment
Route::post('comment', 'CommentsController@storeComment')->name('create comment');

/*
|--------------------------------------------------------------------------
| ADMIN MIDDLEWARE ROUTES
|--------------------------------------------------------------------------
|
| Below are avaible routes only accessible by an admin user.
| All routes are prefix with 'admin' ie /admin/some/path
|
*/
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
    Route::get('tickets', 'TicketsController@index')->name('tickets');
    Route::post('tickets/close/{ticket_id}', 'TicketsController@close')->name('close');
});
