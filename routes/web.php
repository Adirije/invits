<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    $invite = App\Models\Invitation::with('event')->find(1);
    return view('mail.invitation', compact('invite'));
});

Route::get('/', function () {
    return redirect(route('public.home'));
});


Route::get('/home', 'HomeController@index')->name('public.home');
Route::get('/about', 'AboutController@index')->name('public.about');
Route::get('/gallery', 'GalleryController@index')->name('public.gallery');
Route::get('/contact', 'ContactController@index')->name('public.contact.index');

//invitations
Route::get('/invitations/{slug}', 'InvitationController@showRegForm')->name('public.invites.showReg');
Route::post('/invitations/{slug}', 'InvitationController@store')->name('public.invites.store');
Route::get('/invitations/{slug}/decline', 'InvitationController@showDeclinePage')->name('public.invitations.showDeclinePage');
Route::post('/invitations/{slug}/decline', 'InvitationController@decline')->name('public.invitations.decline');

Route::get('/events', 'EventController@index')->name('public.events');
Route::get('/events/{slug}', 'EventController@show')->name('public.events.show');
Route::get('/events/{slug}/checkout', 'TicketPaymentController@create')->name('public.tickets.initCheckout');

//payments
Route::post('/payments/verify-invite/{ref}', 'TicketPaymentController@verifyInvitePayment')->name('public.payments.verifyInvite');
Route::post('/payments/verify/{ref}', 'TicketPaymentController@verifyPayment')->name('public.payments.verify');
Route::post('/payments/init', 'TicketPaymentController@initPayment')->name('public.events.initPayment');

//tickets
Route::get('/tickets/print-paid', 'TicketController@printTickets')->name('public.tickets.printPaid');
Route::get('/tickets/print-free', 'TicketController@printFree')->name('public.tickets.printFree');


//contact meesage
Route::post('/contact-message', 'ContactMessageController@store')->name('contact_message.store');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('login', 'LoginController@showLoginForm')->name('admin.login.form');
    Route::post('login', 'LoginController@login')->name('admin.login');
    Route::post('logout', 'LoginController@logout')->name('admin.logout');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth:admin']], function () {

    Route::get('/', function(){
        return redirect(route('admin.events.index'));
    });

    Route::get('events', 'EventController@index')->name('admin.events.index');
    Route::get('events/create', 'EventController@create')->name('admin.events.create');
    Route::post('events', 'EventController@store')->name('admin.events.store');
    Route::get('events/{id}', 'EventController@show')->name('admin.events.show');
    Route::post('events/{id}', 'EventController@update')->name('admin.events.update');
    Route::get('events/{id}/edit', 'EventController@edit')->name('admin.events.edit');
    Route::post('events/{id}/delete', 'EventController@destroy')->name('admin.events.delete');
    
    
    //locations
    Route::get('/locations', 'LocationController@index')->name('admin.locations.index');
    Route::get('/locations/create', 'LocationController@index')->name('admin.locations.create');
    Route::get('/locations/{id}', 'LocationController@show')->name('admin.locations.show');
    Route::post('/locations/{id}/delete', 'LocationController@destroy')->name('admin.locations.delete');
    Route::post('/locations/{id}/update', 'LocationController@update')->name('admin.locations.update');
    Route::post('/locations', 'LocationController@store')->name('admin.locations.store');
    
    //clients
    Route::get('/clients', 'ClientController@index')->name('admin.clients.index');
    Route::post('/clients', 'ClientController@store')->name('admin.clients.store');
    Route::post('/clients/{id}', 'ClientController@update')->name('admin.clients.update');
    
    //tickets
    Route::post('/tickets', 'TicketController@store')->name('admin.tickets.store');
    Route::post('/tickets/{id}/update', 'TicketController@update')->name('admin.tickets.update');
    Route::get('/tickets/{id}/sales', 'TicketController@sales')->name('admin.tickets.sales');
    
    //gallery
    Route::get('/gallery', 'GalleryController@index')->name('admin.gallery.index');
    Route::post('/gallery', 'GalleryController@store')->name('admin.gallery.store');
    Route::post('/gallery/{id}/update', 'GalleryController@update')->name('admin.gallery.update');
    Route::post('/gallery/{id}/destroy', 'GalleryController@destroy')->name('admin.gallery.destroy');
    
    //registrations
    Route::post('/registrations/events/{id}/', 'EventRegistrationController@store')->name('admin.registrations.store');
    Route::get('/registrations/events/{id?}/', 'EventRegistrationController@index')->name('admin.registrations');
    Route::get('/registrations/events/{id}/print', 'EventRegistrationController@print')->name('admin.registrations.print');
    // Route::get('/registrations/events/free/{id}/print', 'EventRegistrationController@printFree')->name('admin.registrations.print');
    
    //checkin
    Route::post('/checkins', 'CheckinController@store')->name('admin.checkins.store');
    Route::post('/checkins/offline', 'CheckinController@storeOffline');
    Route::get('/checkins/events/{id?}', 'CheckinController@index')->name('admin.checkins');
    Route::get('/checkins/events/{id}/print', 'CheckinController@printIndex')->name('admin.checkins.print');
    Route::get('/checkings/events/{id}/guests', 'CheckinController@create')->name('admin.checkins.guests');
    Route::get('/checkins/verifycode/{code}', 'CheckinController@verifyCode');
    
    //finances - index
    Route::get('/finance/events/{eventId?}', 'FinanceController@index')->name('admin.finance.index');
    
    //finances - income
    Route::get('/finance/events/{eventId}/income', 'IncomeController@index')->name('admin.finance.income.index');
    Route::get('/finance/events/{eventId}/income/print', 'IncomeController@print')->name('admin.finance.income.print');
    Route::post('/finance/events/{eventId}/income', 'IncomeController@store')->name('admin.finance.income.store');
    Route::post('/finance/incomes/{id}/update', 'IncomeController@update')->name('admin.finance.income.update');
    Route::post('/finance/incomes/{id}/destroy', 'IncomeController@destroy')->name('admin.finance.income.destroy');
    
    //finances - expense
    Route::get('/finance/events/{eventId}/expenses', 'ExpenseController@index')->name('admin.finance.expenses.index');
    Route::post('/finance/events/{eventId}/expenses', 'ExpenseController@store')->name('admin.finance.expenses.store');
    Route::post('/finance/expenses/{id}/update', 'ExpenseController@update')->name('admin.finance.expenses.update');
    Route::post('/finance/expenses/{id}/destroy', 'ExpenseController@destroy')->name('admin.finance.expenses.destroy');
    Route::get('/finance/events/{eventId}/expenses/print', 'ExpenseController@print')->name('admin.finance.expenses.print');

    //invitations
    Route::get('/invitations/events/{eventId?}', 'InvitationController@index')->name('admin.invitations.index');
    Route::post('/invitations/events/{eventId}', 'InvitationController@store')->name('admin.invitations.store');
    Route::post('/invitations/{id}/delete', 'InvitationController@destroy')->name('admin.invitations.destroy');    

    //messages
    Route::get('messages', 'ContactMessageController@index')->name('admin.messages.index');
    Route::post('messages/{contactMessage}/read', 'ContactMessageController@read')->name('admin.messages.read');
    Route::post('messages/{contactMessage}/delete', 'ContactMessageController@destroy')->name('admin.messages.destroy');

});