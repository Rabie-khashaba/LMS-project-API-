<?php

use App\Http\Controllers\Api\LMS\CourseController;
use App\Http\Controllers\Api\LMS\LessonController;
use App\Http\Controllers\Api\LMS\Commentcontroller;
use App\Http\Controllers\Api\LMS\RatingController;
use App\Http\Controllers\Api\LMS\SubscriptionController;
use App\Http\Controllers\Api\LMS\CertificateController;
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
    Route::get('Courses' , [CourseController::class, 'index']);
    Route::get('Course/{id}' , [CourseController::class, 'show']);
    Route::post('updateCourse/{id}' , [CourseController::class, 'update']);
    Route::get('deleteCourse/{id}' , [CourseController::class, 'destroy']);

});

//Course-------> only teacher can add Course
Route::middleware(['auth:sanctum' , 'role:teacher'])->group(function () {
    //create course
    Route::post('storeCourse' , [CourseController::class, 'store']);

    //upload file
    Route::post('upload' , [\App\Http\Controllers\Api\LMS\MediaController::class, 'uploadFiles']);

    //progress a lesson
    Route::post('lessonProgress' , [\App\Http\Controllers\Api\LMS\LessonProgressController::class, 'lessonProgress']);


});

//lessons
Route::middleware('auth:sanctum')->group(function () {
    Route::post('storeLesson' , [LessonController::class, 'store']);
    Route::get('Lessons' , [LessonController::class, 'index']);
    Route::get('Lesson/{id}' , [LessonController::class, 'show']);
    Route::post('updateLesson/{id}' , [LessonController::class, 'update']);
    Route::get('deleteLesson/{id}' , [LessonController::class, 'destroy']);

});

Route::middleware(['auth:sanctum' , 'role:teacher'])->group(function () {

});


Route::middleware(['auth:sanctum' , 'role:student'])->group(function () {
    Route::post('showVideo' , [\App\Http\Controllers\Api\LMS\MediaController::class, 'show']);
});


//comments
Route::middleware('auth:sanctum')->group(function () {
    Route::post('storeComment' , [Commentcontroller::class, 'store']);
    Route::get('Comments' , [Commentcontroller::class, 'index']);
    Route::get('Comment/{id}' , [Commentcontroller::class, 'show']);
    Route::post('updateComment/{id}' , [Commentcontroller::class, 'update']);
    Route::get('deleteComment/{id}' , [Commentcontroller::class, 'destroy']);

});

//Rating
Route::middleware('auth:sanctum')->group(function () {
    Route::post('storeRate' , [RatingController::class, 'store']);
    Route::get('Rates' , [RatingController::class, 'index']);
    Route::get('Rate/{id}' , [RatingController::class, 'show']);
    Route::post('updateRate/{id}' , [RatingController::class, 'update']);
    Route::get('deleteRate/{id}' , [RatingController::class, 'destroy']);

});


//Subscription
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/purchase', [SubscriptionController::class, 'purchase']);
    Route::get('/subscribe', [SubscriptionController::class, 'show'])->name('subscribe.form');
    Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');
    Route::get('/status', [SubscriptionController::class, 'status'])->name('status');
    Route::get('/invoices', [SubscriptionController::class, 'invoices'])->name('invoices');

});

//certificate for complete Course
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/certificate/download', [CertificateController::class, 'download']);
});













