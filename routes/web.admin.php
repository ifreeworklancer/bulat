<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'DashboardController@index')->name('index');

Route::resource('articles', 'ArticlesController')->except(['show']);
Route::resource('groups', 'GroupsController')->except(['show']);
Route::resource('tags', 'TagsController')->except(['show']);

Route::resource('categories', 'CategoriesController')->except(['show']);
Route::resource('products', 'ProductsController')->except(['show']);
Route::resource('orders', 'OrdersController')->except(['create', 'destroy']);

Route::resource('users', 'UsersController')->except(['create', 'store']);

Route::resource('slides', 'SlidesController')->except(['show']);
Route::resource('settings', 'SettingsController')->only(['index', 'update']);

Route::resource('questions', 'QuestionsController')->except(['show']);
Route::resource('answers', 'AnswersController')->except(['show']);

Route::delete('media/{media}', 'MediaController@destroy')->name('media.delete');
