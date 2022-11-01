<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCourseController;
use Illuminate\Http\Request;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('jwt.verify')->group(function () {
    // User routes
    Route::get('get-users', [UserController::class, 'index']);
    Route::get('get-user/{id}', [UserController::class, 'show']);
    Route::put('edit-user/{id}', [UserController::class, 'update']);
    Route::delete('delete-user/{id}', [UserController::class, 'destroy']);
    // Courses route
    Route::get('get-courses', [CourseController::class, 'index']);
    Route::get('get-course/{id}', [CourseController::class, 'show']);
    Route::post('create-course', [CourseController::class, 'store']);
    Route::put('edit-course/{id}', [CourseController::class, 'update']);
    Route::delete('delete-course/{id}', [CourseController::class, 'destroy']);
    // Enrollment routes
    Route::get('get-enrollments', [UserCourseController::class, 'index']);
    Route::post('save-enrollment', [UserCourseController::class, 'store']);
    Route::delete('delete-enrollment/{id}', [UserCourseController::class, 'destroy']);
});
