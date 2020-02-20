<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('api/v1')->group(function () {
    Route::post('/auth/login', 'PassportController@login');
    Route::post('/register', 'PassportController@register');
    Route::middleware('auth:api')->group(function () {
        Route::resource('/product', 'ProductController');
        Route::resource('/bank', 'BankController');
        Route::get('/bank-search', 'BankController@search');
        Route::resource('/sport', 'SportController');
        Route::get('/sport-search', 'SportController@search');
        Route::resource('/profession', 'ProfessionController');
        Route::get('/profession-search', 'ProfessionController@search');
        Route::resource('/country', 'CountryController');
        Route::get('/country-search', 'CountryController@search');
        Route::resource('/person', 'PersonController');
        Route::get('/person-search', 'PersonController@search');
        Route::resource('/status-person', 'StatusPersonController');
        Route::get('/status-person-search', 'StatusPersonController@search');
        Route::resource('/marital-status', 'MaritalStatusController');
        Route::get('/marital-status-search', 'MaritalStatusController@search');
        Route::resource('/gender', 'GenderController');
        Route::get('/gender-search', 'GenderController@search');
        Route::get('/check-login', 'UserController@checkLogin');
        Route::get('/product-search', 'ProductController@search');
        Route::resource('/user', 'UserController');
    });
});