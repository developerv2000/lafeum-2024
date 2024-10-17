<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Support\Generators\CrudRouteGenerator;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->prefix('/dashboard')->name('dashboard.')->group(function () {
    Route::redirect('/', '/dashboard/quotes');

    Route::controller(QuoteController::class)->prefix('/quotes')->name('quotes.')->group(function () {
        CrudRouteGenerator::defineDefaultRoutesExcept(['index']);   
        Route::get('/', 'dashboardIndex');
        Route::get('/{record}', 'dashboardShow');
    });

    Route::controller(AuthorController::class)->prefix('/authors')->name('authors.')->group(function () {
        CrudRouteGenerator::defineAllDefaultRoutes();
    });

    Route::controller(TermController::class)->prefix('/terms')->name('terms.')->group(function () {
        CrudRouteGenerator::defineAllDefaultRoutes();
    });

    Route::controller(PhotoController::class)->prefix('/photos')->name('photos.')->group(function () {
        CrudRouteGenerator::defineAllDefaultRoutes();
    });

    Route::controller(VideoController::class)->prefix('/videos')->name('videos.')->group(function () {
        CrudRouteGenerator::defineAllDefaultRoutes();
    });

    Route::controller(ChannelController::class)->prefix('/channels')->name('channels.')->group(function () {
        CrudRouteGenerator::defineAllDefaultRoutes();
    });

    Route::controller(CategoryController::class)->prefix('/categories/{model}')->name('categories.')->group(function () {
        CrudRouteGenerator::defineDefaultRoutesExcept(['trash', 'restore']);
    });

    Route::controller(UserController::class)->prefix('/users')->name('users.')->group(function () {
        CrudRouteGenerator::defineDefaultRoutesOnly(['index', 'delete']);
    });

    Route::controller(FeedbackController::class)->prefix('/feedbacks')->name('feedbacks.')->group(function () {
        CrudRouteGenerator::defineDefaultRoutesOnly(['index', 'delete']);
    });
});
