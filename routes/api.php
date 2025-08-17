<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\BillPaymentController;
use App\Http\Controllers\ChoreController;
use App\Http\Controllers\CommunityCommentController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\CommunityPostController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacancyNotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
use App\Http\Controllers\AuthController;

Route::post('/users', [AuthController::class, 'register']);




Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/documents', [DocumentController::class, 'store']); // Protecting your document upload
});



    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::post('users', [UserController::class, 'store']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('bills', [BillController::class, 'index']);
    Route::get('bills/{id}', [BillController::class, 'show']);
    Route::post('bills', [BillController::class, 'store']);
    Route::put('bills/{id}', [BillController::class, 'update']);
    Route::delete('bills/{id}', [BillController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/documents', [DocumentController::class, 'index']);
    Route::post('/documents', [DocumentController::class, 'store']);
    Route::get('/documents/{id}', [DocumentController::class, 'show']);
    Route::put('/documents/{id}', [DocumentController::class, 'update']);
    Route::delete('/documents/{id}', [DocumentController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('messages', [MessageController::class, 'index']);
    Route::post('messages', [MessageController::class, 'store']);
    Route::get('messages/{id}', [MessageController::class, 'show']);
    Route::put('messages/{id}', [MessageController::class, 'update']);
    Route::delete('messages/{id}', [MessageController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/payments', [BillPaymentController::class, 'index']);
    Route::post('/payments', [BillPaymentController::class, 'store']);
    Route::get('/payments/{id}', [BillPaymentController::class, 'show']);
    Route::put('/payments/{id}', [BillPaymentController::class, 'update']);
    Route::delete('/payments/{id}', [BillPaymentController::class, 'destroy']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/chores', [ChoreController::class, 'index']);      // Get all chores
    Route::post('/chores', [ChoreController::class, 'store']);     // Create a new chore
    Route::get('/chores/{id}', [ChoreController::class, 'show']);  // Get a specific chore by ID
    Route::put('/chores/{id}', [ChoreController::class, 'update']); // Update a specific chore
    Route::delete('/chores/{id}', [ChoreController::class, 'destroy']); // Delete a specific chore
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/comments', [CommunityCommentController::class, 'index']);         // Get all comments
    Route::post('/comments', [CommunityCommentController::class, 'store']);        // Create a new comment
    Route::get('/comments/{id}', [CommunityCommentController::class, 'show']);     // Get a specific comment by ID
    Route::put('/comments/{id}', [CommunityCommentController::class, 'update']);   // Update a specific comment
    Route::delete('/comments/{id}', [CommunityCommentController::class, 'destroy']); // Delete a specific comment
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/communities', [CommunityController::class, 'index']);           // Get all communities
    Route::post('/communities', [CommunityController::class, 'store']);          // Create a new community
    Route::get('/communities/{id}', [CommunityController::class, 'show']);       // Get a specific community by ID
    Route::put('/communities/{id}', [CommunityController::class, 'update']);     // Update a specific community
    Route::delete('/communities/{id}', [CommunityController::class, 'destroy']); // Delete a specific community
});

Route::resource('/room',RoomController::class);
Route::resource('/bill',BillController::class);
Route::resource('/payment',BillPaymentController::class);
Route::resource('/chore',ChoreController::class);
Route::resource('/notification',NotificationController::class);
Route::resource('/community',CommunityController::class);
Route::resource('/post',CommunityPostController::class);
Route::resource('/comments',CommunityCommentController::class);
Route::resource('/vacancy',VacancyNotificationController::class);
Route::resource('/user',UserController::class);
Route::resource('/userroom',RoomUserController::class);
Route::get('users', [UserController::class, 'index']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/posts', [CommunityPostController::class, 'index']);           // Get all community posts
    Route::post('/posts', [CommunityPostController::class, 'store']);          // Create a new post
    Route::get('/posts/{id}', [CommunityPostController::class, 'show']);       // Get a specific post by ID
    Route::put('/posts/{id}', [CommunityPostController::class, 'update']);     // Update a specific post
    Route::delete('/posts/{id}', [CommunityPostController::class, 'destroy']); // Delete a specific post
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);            // Get all notifications
    Route::post('/notifications', [NotificationController::class, 'store']);           // Create a new notification
    Route::get('/notifications/{id}', [NotificationController::class, 'show']);        // Get a specific notification by ID
    Route::put('/notifications/{id}', [NotificationController::class, 'update']);      // Update a specific notification
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);  // Delete a specific notification
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('rooms', [RoomController::class, 'index']); // Get all rooms
    Route::post('rooms', [RoomController::class, 'store']); // Create a new room
    Route::get('rooms/{id}', [RoomController::class, 'show']); // Get a specific room by ID
    Route::put('rooms/{id}', [RoomController::class, 'update']); // Update a specific room by ID
    Route::delete('rooms/{id}', [RoomController::class, 'destroy']); // Delete a specific room by ID
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('roomusers', [RoomUserController::class, 'index']); // Get all room users
    Route::post('roomusers', [RoomUserController::class, 'store']); // Create a new room user
    Route::get('roomusers/{id}', [RoomUserController::class, 'show']); // Get a specific room user
    Route::put('roomusers/{id}', [RoomUserController::class, 'update']); // Update a specific room user
    Route::delete('roomusers/{id}', [RoomUserController::class, 'destroy']); // Delete a specific room user
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('vacancies', [VacancyNotificationController::class, 'index']); // Get all vacancy notifications
    Route::post('vacancies', [VacancyNotificationController::class, 'store']); // Create a new vacancy notification
    Route::get('vacancies/{id}', [VacancyNotificationController::class, 'show']); // Get a specific vacancy notification
    Route::put('vacancies/{id}', [VacancyNotificationController::class, 'update']); // Update a specific vacancy notification
    Route::delete('vacancies/{id}', [VacancyNotificationController::class, 'destroy']); // Delete a specific vacancy notification
});
