<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

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

Route::resource('/classroom',Api\ClassroomController::class);
Route::get('/classroom/{classroom}/lecture',[Api\ClassroomController::class,'get'])->name('classroom.lectures.get');
Route::post('/classroom/{classroom}/lecture',[Api\ClassroomController::class,'set'])->name('classroom.lectures.set');
Route::resource('/lecture',Api\LectureController::class);
Route::resource('/student',Api\StudentController::class);
