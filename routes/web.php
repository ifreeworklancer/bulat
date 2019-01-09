<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group([
	'as' => 'admin.',
	'prefix' => 'admin',
	'namespace' => 'Admin',
	'middleware' => ['auth', 'admin'],
], function () {
	require_once(base_path('routes/web.admin.php'));
});

Route::group([
	'as' => 'app.',
	'namespace' => 'Front',
], function () {
	require_once('web.app.php');
});