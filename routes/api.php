<?php

use App\Http\Controllers\Api\OrganisationController;
use App\Http\Middleware\AccessKeyMiddleware;
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

Route::group(['prefix' => 'organisations', 'middleware' => AccessKeyMiddleware::class], function () {
    Route::get('/', [OrganisationController::class, 'index']);
    Route::get('/by-activity', [OrganisationController::class, 'getByActivity']);

    Route::get('show/{organisationId}', [OrganisationController::class, 'show']);
});
