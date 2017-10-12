<?php

Route::group(['prefix' => 'api/v1'], function () {
    Route::post('/auth', 'ApiController@login');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/logout', 'ApiController@logout');
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('admins', 'UsersController@index');
    Route::get('admins/item/{item_id?}', 'UsersController@item');
    Route::post('admins/item/{item_id?}', 'UsersController@store');
    Route::delete('admins/item/{item_id?}', 'UsersController@deleteItem');

    Route::get('contacts', 'ContactsController@index');
    Route::get('contacts/item/{item_id?}', 'ContactsController@item');
    Route::post('contacts/item/{item_id?}', 'ContactsController@store');
    Route::delete('contacts/item/{item_id?}', 'ContactsController@deleteItem');

    Route::get('apartments', 'ApartmentsController@index');
    Route::get('apartments/item/{item_id?}', 'ApartmentsController@item');
    Route::post('apartments/item/{item_id?}', 'ApartmentsController@store');
    Route::delete('apartments/item/{item_id?}', 'ApartmentsController@deleteItem');

});

Route::get('api-docs', 'DocsController@index');
Route::get('login', 'HomeController@login');
Route::post('login', 'HomeController@postLogin');
Route::get('logout', 'HomeController@logout');
Route::get('/', 'HomeController@index');
