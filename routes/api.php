<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Article\v1\ArticleControllerV1;
use App\Http\Controllers\Article\v2\ArticleControllerV2;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\User\UserController;
use App\Jobs\SendWeeklyArticlesReport;


    Route::get('/register',[UserController::class,'register'])->middleware(['throttle:api']);
    
    Route::get('/login',[UserController::class,'login'])->middleware(['throttle:api']);

    Route::prefix('v1')->group(function () {
        Route::get('/pulished_articles', [ArticleControllerV1::class, 'allPublished'])->middleware(['auth:sanctum','throttle:api']);
        
        Route::get('/show_articles/{id}',[ArticleControllerV1::class,'find'])->middleware(['auth:sanctum','throttle:api']);

        Route::get('/delete_articles/{id}',[ArticleControllerV1::class,'delete'])->middleware(['auth:sanctum','throttle:api']);
        
        Route::post('/update_articles/{id}',[ArticleControllerV1::class,'update'])->middleware(['auth:sanctum','throttle:api']);

        Route::post('/create_articles',[ArticleControllerV1::class,'create'])->middleware(['auth:sanctum','throttle:api']);
        
        Route::get('/publish_articles/{id}',[ArticleControllerV1::class,'publish'])->middleware(['auth:sanctum','throttle:api']);

        Route::get('/dashboard',[UserController::class,'dashboard'])->middleware(['auth:sanctum','throttle:api']);
        
        
        });

    Route::prefix('v2')->group(function () {
        Route::get('/pulished_articles', [ArticleControllerV2::class, 'allPublished'])->middleware(['auth:sanctum','throttle:api']);
    });

    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])
    ->middleware(['auth:sanctum','throttle:api']);


