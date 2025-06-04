<?php

use App\Http\Controllers\Api\LMS\CourseController;
use App\Http\Controllers\Api\LMS\LessonController;
use App\Http\Controllers\Api\LMS\Commentcontroller;
use Illuminate\Support\Facades\Route;



Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::post('store', [\App\Http\Controllers\Api\PostController::class, 'store']);
    Route::post('posts', [\App\Http\Controllers\Api\PostController::class, 'index']);


    Route::post('sendOTP', [\App\Http\Controllers\Api\AuthController::class, 'sendOTP']);
    Route::post('changePassword', [\App\Http\Controllers\Api\AuthController::class, 'verifyOTpAndChangPassworrd']);
    Route::post('refreshToken', [\App\Http\Controllers\Api\AuthController::class, 'refreshToken']);


    //send notification by firebase
    Route::post('sendNotification', [\App\Http\Controllers\Api\FirebaseNotificationController::class, 'sendN']);

});


//Course
Route::middleware('auth:sanctum')->group(function () {
    Route::post('storeCourse' , [CourseController::class, 'store']);
    Route::get('Courses' , [CourseController::class, 'index']);
    Route::get('Course/{id}' , [CourseController::class, 'show']);
    Route::post('updateCourse/{id}' , [CourseController::class, 'update']);
    Route::get('deleteCourse/{id}' , [CourseController::class, 'destroy']);

});

//lessons
Route::middleware('auth:sanctum')->group(function () {
    Route::post('storeLesson' , [LessonController::class, 'store']);
    Route::get('Lessons' , [LessonController::class, 'index']);
    Route::get('Lesson/{id}' , [LessonController::class, 'show']);
    Route::post('updateLesson/{id}' , [LessonController::class, 'update']);
    Route::get('deleteLesson/{id}' , [LessonController::class, 'destroy']);

});


//comments
Route::middleware('auth:sanctum')->group(function () {
    Route::post('storeComment' , [Commentcontroller::class, 'store']);
    Route::get('Comments' , [Commentcontroller::class, 'index']);
    Route::get('Comment/{id}' , [Commentcontroller::class, 'show']);
    Route::post('updateComment/{id}' , [Commentcontroller::class, 'update']);
    Route::get('deleteComment/{id}' , [Commentcontroller::class, 'destroy']);

});









