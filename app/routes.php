<?php

Route::group(['namespace' => 'Snappy\Http\Controllers'], function()
{
    Route::get('/', function() {
        return View::make('application');
    });

    Route::group(['prefix' => 'api/v1', 'namespace' => 'Api'], function()
    {
        Route::post('login', 'AuthController@attempt');
        Route::get('logout', 'AuthController@logout');
        Route::post('register', 'AuthController@register');

        Route::group(['before' => 'auth'], function()
        {
            Route::get('users', 'UsersController@index');
            Route::post('users', 'UsersController@store');
            Route::get('users/me', 'UsersController@me');
            Route::put('users/me', 'UsersController@update');

            Route::resource('chats', 'ChatsController', ['only' => ['index', 'store', 'show', 'destroy']]);
            Route::post('chats/{id}/messages', 'ChatsController@addMessage');
            Route::post('chats/{id}/recipients', 'ChatsController@addRecipient');
        });
    });
});
