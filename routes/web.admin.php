<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'admin.',
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['auth', 'admin'],
], function () {

    Route::get('/', function () {
        return redirect()->route('admin.orders.index');
    })->name('home');

    Route::resource('pages', 'PagesController')->only('index', 'edit', 'update');
    Route::resource('articles', 'ArticlesController')->except(['show']);
    Route::resource('groups', 'GroupsController')->except(['show']);
    Route::resource('tags', 'TagsController')->except(['show']);

    Route::resource('products', 'ProductsController')->except(['show']);
    Route::post('products/order/{product}/{direction}', 'ProductsController@sortOrder')
        ->name('products.sort');

    Route::resource('categories', 'CategoriesController')->except(['show']);
    Route::post('categories/order/{category}/{direction}', 'CategoriesController@sortOrder')
        ->name('categories.sort');
    Route::resource('orders', 'OrdersController')->except(['create', 'destroy']);

    Route::resource('users', 'UsersController')->except(['create', 'store']);

    Route::resource('slides', 'SlidesController')->except(['show']);
    Route::resource('settings', 'SettingsController')->only(['index', 'update']);

    Route::resource('questions', 'QuestionsController')->except(['show']);
    Route::resource('answers', 'AnswersController')->except(['show']);

    Route::group([
        'as' => 'media.',
        'prefix' => 'media',
    ], function () {
        Route::post('upload', 'MediaController@upload')->name('upload');
        Route::delete('{media}/delete', 'MediaController@destroy')->name('destroy');
    });

});