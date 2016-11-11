<?php

Route::group(['prefix' => 'econt', 'middleware' => 'Simexis\Econt\Http\Middleware\Econt'], function () {
    Route::get('zones', ['as' => 'econt.zones', 'uses' => 'Simexis\Econt\Http\Controllers\EcontController@zones']);
    Route::get('neighbourhoods', ['as' => 'econt.neighbourhoods', 'uses' => 'Simexis\Econt\Http\Controllers\EcontController@neighbourhoods']);

    Route::post('profile', ['as' => 'econt.profile', 'uses' => 'Simexis\Econt\Http\Controllers\EcontController@profile']);
    Route::post('company', ['as' => 'econt.company', 'uses' => 'Simexis\Econt\Http\Controllers\EcontController@company']);

    Route::get('settlements', ['as' => 'econt.settlements', 'uses' => 'Simexis\Econt\Http\Controllers\SettlementController@index']);
    Route::get('settlements/autocomplete', [ 'as' => 'econt.settlements.autocomplete', 'uses' => 'Simexis\Econt\Http\Controllers\SettlementController@autocomplete']);

    Route::get('streets', ['as' => 'econt.streets', 'uses' => 'Simexis\Econt\Http\Controllers\StreetController@index']);
    Route::get('streets/autocomplete', ['as' => 'econt.streets.autocomplete', 'uses' => 'Simexis\Econt\Http\Controllers\StreetController@autocomplete']);

    Route::get('offices/autocomplete/name', [ 'as' => 'econt.offices.autocomplete.name', 'uses' => 'Simexis\Econt\Http\Controllers\OfficeController@autocompleteBySettlementName']);
    Route::get('offices/autocomplete', [ 'as' => 'econt.offices.autocomplete', 'uses' => 'Simexis\Econt\Http\Controllers\OfficeController@autocomplete']);
    Route::get('offices/dropdown', [ 'as' => 'econt.offices.dropdown', 'uses' => 'Simexis\Econt\Http\Controllers\OfficeController@dropdown']);
    Route::get('offices/{id}', ['as' => 'econt.offices.show', 'uses' => 'Simexis\Econt\Http\Controllers\OfficeController@show']);
    Route::get('offices', ['as' => 'econt.offices', 'uses' => 'Simexis\Econt\Http\Controllers\OfficeController@index']);

    Route::post('waybill/issue', ['as' => 'econt.waybill.issue', 'uses' => 'Simexis\Econt\Http\Controllers\WaybillController@issue']);
    Route::post('waybill/calculate', [ 'as' => 'econt.waybill.calculate', 'uses' => 'Simexis\Econt\Http\Controllers\WaybillController@calculate']);

    Route::get('shipment/types', [ 'as' => 'econt.shipment.types', 'uses' => 'Simexis\Econt\Http\Controllers\ShipmentController@index']);
});