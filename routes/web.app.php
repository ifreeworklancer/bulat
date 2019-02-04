<?php

use Illuminate\Support\Facades\Route;

Route::group([
	'as' => 'app.',
	'namespace' => 'Front',
], function () {

	Route::get('/', 'PagesController@index')->name('home');
	Route::get('about', 'PagesController@about')->name('about');
	Route::get('contacts', 'PagesController@contacts')->name('contacts');
	Route::get('locale/{lang}', 'LocaleController@switch')->name('locale');
	Route::view('thanks', 'app.pages.thanks')->name('thanks');


	Route::get('search', 'SearchController@index')->name('search');

	Route::group([
		'as' => 'catalog.',
	], function () {
		Route::get('catalog', 'CatalogController@index')->name('index');
		Route::post('catalog', 'CatalogController@index')->name('search');
		Route::get('lot/{product}', 'CatalogController@show')->name('show');
		Route::post('lot/{product}/favorites', 'CatalogController@toggleFavorites')->name('favorites');
		Route::post('lot/{product}', 'OrderController')->name('buy');
	});

	Route::group([
		'as' => 'articles.',
		'prefix' => 'articles',
	], function () {
		Route::get('/', 'ArticlesController@index')->name('index');
		Route::post('{article}/favorites', 'ArticlesController@toggleFavorites')->name('favorites');
		Route::get('{article}', 'ArticlesController@show')->name('show');
	});

	Route::group([
		'as' => 'profile.',
		'prefix' => 'profile',
		'middleware' => ['auth'],
	], function () {
		Route::get('/', 'ProfileController@index')->name('index');
		Route::post('cities', 'ProfileController@getCities')->name('cities');
		Route::patch('update', 'ProfileController@update')->name('update');
	});

	Route::group([
		'as' => 'questionary.',
		'middleware' => ['auth'],
	], function () {
		Route::get('questionary', 'AnswersController@index')->name('index');
		Route::post('questionary', 'AnswersController@store')->name('store');
	});

});