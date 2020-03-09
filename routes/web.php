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

        Route::resource('/bank', 'BankController');
        Route::get('/bank-search', 'BankController@search');
        Route::resource('/sport', 'SportController');
        Route::get('/sport-search', 'SportController@search');
        Route::resource('/profession', 'ProfessionController');
        Route::get('/profession-search', 'ProfessionController@search');
        Route::resource('/country', 'CountryController');
        Route::get('/country-search', 'CountryController@search');
        Route::resource('/person-relation', 'PersonRelationController');
        Route::resource('/person', 'PersonController');
        Route::get('/person-search', 'PersonController@search');
        Route::get('/search-person-to-assign', 'PersonController@searchPersonsToAssign');
        Route::get('/search-family-by-person', 'PersonController@searchFamilyByPerson');
        Route::get('/report-by-partner', 'PersonController@getReportByPartner');
        Route::post('/assign-person', 'PersonController@assignPerson');
        Route::resource('/status-person', 'StatusPersonController');
        Route::get('/status-person-search', 'StatusPersonController@search');
        Route::resource('/marital-status', 'MaritalStatusController');
        Route::get('/marital-status-search', 'MaritalStatusController@search');
        Route::resource('/gender', 'GenderController');
        Route::get('/gender-search', 'GenderController@search');
        Route::resource('/relation-type', 'RelationTypeController');
        Route::get('/relation-type-search', 'RelationTypeController@search');
        Route::resource('/role', 'RoleController');
        Route::get('/role-search', 'RoleController@search');
        Route::resource('/permission', 'PermissionController');
        Route::get('/permission-search', 'PermissionController@search');
        Route::get('/check-login', 'UserController@checkLogin');
        Route::get('/product-search', 'ProductController@search');
        Route::resource('/user', 'UserController');
        Route::get('/person-report', 'PersonController@report');
        Route::resource('/payment-method', 'PaymentMethodController');
        Route::get('/payment-method-search', 'PaymentMethodController@search');
        Route::resource('/card-type', 'CardTypeController');
        Route::get('/card-type-search', 'CardTypeController@search');
        Route::resource('/transaction-type', 'TransactionTypeController');
        Route::get('/transaction-type-search', 'TransactionTypeController@search');
        Route::resource('/share', 'ShareController');
        Route::get('/share-by-partner/{id}', 'ShareController@getByPartner');
        Route::resource('/card-person', 'CardPersonController');
        Route::resource('/share-movement', 'ShareMovementController');
        Route::get('/share-movement-search', 'ShareMovementController@search');
        Route::get('/search-to-assign', 'ShareController@searchToAssign');
        Route::get('/search-person-to-assign', 'PersonController@searchToAssign');
    });
});

/* Reports */
Route::get('/person-report', 'PersonController@report');
Route::get('/partner-report', 'PersonController@getReportByPartner');