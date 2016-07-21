<?php

Route::get('/', function () {
    return view('index');
});


Route::get('login', function () {
    return view('login');
});