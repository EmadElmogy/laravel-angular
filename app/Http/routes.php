<?php

Route::group(['prefix' => 'api/v1'], function () {
    Route::post('/auth', 'ApiController@login');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/logout', 'ApiController@logout');
        Route::get('/wiki', 'ApiController@wiki');
        Route::get('/sites', 'ApiController@sites');
        Route::get('/categories', 'ApiController@categories');
        Route::get('/products', 'ApiController@products');
        Route::get('/complains', 'ApiController@complains');
        Route::post('/complains', 'ApiController@newComplain');
        Route::get('/customers', 'ApiController@customers');
        Route::get('/reports', 'ApiController@reports');
        Route::get('/reports/{report_id}', 'ApiController@report');
        Route::post('/reports', 'ApiController@newReport');
        Route::post('/stock', 'ApiController@stock');
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('admins', 'UsersController@index');
    Route::get('admins/item/{item_id?}', 'UsersController@item');
    Route::post('admins/item/{item_id?}', 'UsersController@store');
    Route::delete('admins/item/{item_id?}', 'UsersController@deleteItem');

    Route::get('sites', 'SitesController@index');
    Route::get('sites/item/{item_id?}', 'SitesController@item');
    Route::post('sites/item/{item_id?}', 'SitesController@store');
    Route::delete('sites/item/{item_id?}', 'SitesController@deleteItem');

    Route::get('doors', 'DoorsController@index');
    Route::get('doors/item/{item_id?}', 'DoorsController@item');
    Route::post('doors/item/{item_id?}', 'DoorsController@store');
    Route::delete('doors/item/{item_id?}', 'DoorsController@deleteItem');

    Route::get('advisors', 'AdvisorsController@index');
    Route::get('advisors/item/{item_id?}', 'AdvisorsController@item');
    Route::post('advisors/item/{item_id?}', 'AdvisorsController@store');
    Route::delete('advisors/item/{item_id?}', 'AdvisorsController@deleteItem');
    Route::get('advisors/attendance', 'AdvisorsController@attendance');

    Route::get('categories', 'CategoriesController@index');
    Route::get('categories/item/{item_id?}', 'CategoriesController@item');
    Route::post('categories/item/{item_id?}', 'CategoriesController@store');
    Route::delete('categories/item/{item_id?}', 'CategoriesController@deleteItem');

    Route::get('products', 'ProductsController@index');
    Route::get('products/item/{item_id?}', 'ProductsController@item');
    Route::post('products/item/{item_id?}', 'ProductsController@store');
    Route::delete('products/item/{item_id?}', 'ProductsController@deleteItem');

    Route::get('variations', 'VariationsController@index');
    Route::get('variations/item/{item_id?}', 'VariationsController@item');
    Route::post('variations/item/{item_id?}', 'VariationsController@store');
    Route::delete('variations/item/{item_id?}', 'VariationsController@deleteItem');

    Route::get('complains', 'ComplainsController@index');

    Route::get('wikis', 'WikisController@index');
    Route::get('wikis/item/{item_id?}', 'WikisController@item');
    Route::post('wikis/item/{item_id?}', 'WikisController@store');
    Route::delete('wikis/item/{item_id?}', 'WikisController@deleteItem');

    Route::get('reports', 'ReportsController@index');
    Route::get('reports/item/{item_id}', 'ReportsController@item');
    Route::get('reports/sales/products', 'ReportsController@byProducts');
    Route::get('reports/sales/categories', 'ReportsController@byCategories');
    Route::get('reports/sales/doors', 'ReportsController@byDoors');
    Route::get('reports/sales/advisors', 'ReportsController@byAdvisors');

    Route::get('settings', 'SettingsController@index');
    Route::post('settings', 'SettingsController@save');
});

Route::get('api-docs', 'DocsController@index');
Route::get('login', 'HomeController@login');
Route::post('login', 'HomeController@postLogin');
Route::get('logout', 'HomeController@logout');
Route::get('/', 'HomeController@index');