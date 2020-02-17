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

Route::get('/', function () {
    return view('welcome');
});

// System
    // Account
    Route::get('api/accountbyemail/{email}', 'System\AccountController@getByEmail');
    Route::get('api/accountforgotpassword/{email}', 'System\AccountController@forgotPassword');
    Route::put('api/accountrestorepassword/{email}', 'System\AccountController@passwordRestore');    
    Route::apiResource('api/account', 'System\AccountController');
    
    // Hostname
    Route::get('api/hostnameByfqdn/{fqdn}', 'System\HostNameController@showByfqdn');

// Client
    // User
    Route::post('api/userlogin', 'UserController@login');
    Route::post('api/usergetbytoken', 'UserController@getByToken');
    
    //UnitMeasure
    Route::get('api/unitmeasurebyaccount/{idAccount}', 'UnitMeasureController@indexByIdAccount');
    Route::get('api/unitmeasurebyaccountactivated/{idAccount}', 'UnitMeasureController@indexByIdAccountActivated');
    Route::apiResource('api/unitmeasure', 'UnitMeasureController');
    
    //Business
    Route::get('api/businessbyaccount/{idAccount}', 'BusinessController@indexByIdAccount');
    Route::apiResource('api/business', 'BusinessController');
    
    //Establishment
    Route::get('api/establishmentbybusiness/{idBusiness}', 'EstablishmentController@indexByIdBusiness');
    Route::apiResource('api/establishment', 'EstablishmentController');
    
    //Warehouse
    Route::get('api/warehousebybusiness/{idAccount}', 'WarehouseController@indexByIdBusiness');
    Route::apiResource('api/warehouse', 'WarehouseController');
    
    //KardexMotif
    Route::get('api/kardexmotifbyaccount/{idAccount}', 'KardexMotifController@indexByIdAccount');
    Route::get('api/kardexmotifbyaccountandtype/{idAccount}/{type}', 'KardexMotifController@indexByIdAccountAndType');
    Route::apiResource('api/kardexmotif', 'KardexMotifController');
    
    //Product
    Route::get('api/productbybusiness/{idBusiness}', 'ProductController@indexByIdBusiness');
    Route::apiResource('api/product', 'ProductController');
    
    //Kardex - Ingreso y Salida
    Route::get('api/kardexbybusinessandtype/{idBusiness}/{type}', 'KardexController@indexByIdBusinessAndType');
    Route::apiResource('api/kardex', 'KardexController');
    
    //KardexDetalle - Ingreso y Salida
    Route::get('api/kardexdetailbykardex/{idKardex}', 'KardexDetailController@indexByIdKardex');