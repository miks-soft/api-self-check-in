<?php

use App\Http\Controllers\Api\AirportController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/languages', [LanguageController::class, 'index']);

Route::group(['prefix' => '/countries'], function () {
    Route::get('/', [CountryController::class, 'index']);
    Route::get('/{id}/airports', [CountryController::class, 'listAirports'])->where('id', '[0-9]+');
});

Route::group(['prefix' => '/airports'], function () {
    Route::get('/{id}', [AirportController::class, 'show'])->where('id', '[0-9]+');
    Route::get('/{id}/services', [AirportController::class, 'listServices'])->where('id', '[0-9]+');
    Route::get('/{id}/services/search', [AirportController::class, 'searchServices'])->where('id', '[0-9]+');
});

Route::group(['prefix' => '/services'], function () {
    Route::get('/types', [ServiceController::class, 'listTypes']);
    Route::get('/{id}', [ServiceController::class, 'show'])->where('id', '[0-9]+');
    Route::post('/{id}/book', [ServiceController::class, 'book'])->where('id', '[0-9]+');
});

Route::post('/payments/{uuid}/complete', [PaymentController::class, 'complete']);
