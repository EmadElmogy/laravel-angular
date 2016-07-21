<?php

Route::get('sites', 'SitesController@index');
Route::get('sites/item/{item_id?}', 'SitesController@item');
Route::post('sites/item/{item_id?}', 'SitesController@store');
Route::delete('sites/item/{item_id?}', 'SitesController@deleteItem');

Route::get('doors', 'DoorsController@index');
Route::get('doors/item/{item_id?}', 'DoorsController@item');
Route::post('doors/item/{item_id?}', 'DoorsController@store');
Route::delete('doors/item/{item_id?}', 'DoorsController@deleteItem');

//Route::get('advisors', 'AdvisorsController@index');
//Route::get('categories', 'CategoriesController@index');
//Route::get('products', 'ProductsController@index');
//Route::get('reports', 'ReportsController@index');
//Route::get('complains', 'ComplainsController@index');

Route::get('login', 'HomeController@login');
Route::get('/', 'HomeController@index');