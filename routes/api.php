<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
	'namespace' => 'Api'
], function() {
	Route::get('/products', 'ProductsController@index');
});
