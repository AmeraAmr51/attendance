<?php

use App\Http\Controllers\GetTotalHoursController;
use Illuminate\Http\Request;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix' => 'user'], function () {

    Route::post('login', [UserController::class, 'login'])->name('user.login');

    Route::middleware(['token-expired', 'auth:api'])->group(function () {
        Route::post('/attendance', AttendanceController::class)->name('user.attendance');
        Route::get('/total-hours', GetTotalHoursController::class)->name('user.total_hours');
    });
});