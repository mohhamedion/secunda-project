<?php

use App\Http\Controllers\Api\OrganisationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'organisations'], function () {

    Route::get('by-building/{buildingId}', [OrganisationController::class, 'getByBuildingId']);
    Route::get('by-activity/{activityId}', [OrganisationController::class, 'getByActivityId']);
    Route::get('by-rectangle', [OrganisationController::class, 'getByRectangle']);

});
