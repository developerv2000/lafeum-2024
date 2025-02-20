<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Support\Generators\CrudRouteGenerator;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return to_route('dashboard.quotes.index');
})->name('dashboard.index');

Route::middleware(['auth', 'role:admin'])->prefix('/dashboard')->name('dashboard.')->group(function () {
    Route::controller(SettingController::class)->prefix('/settings')->name('settings.')->group(function () {
        Route::patch('preferred-theme', 'toggleTheme')->name('toggle.theme');
        Route::patch('collapsed-leftbar', 'toggleDashboardLeftbar')->name('toggle.leftbar'); // ajax request
    });

    Route::controller(QuoteController::class)->prefix('/quotes')->name('quotes.')->group(function () {
        CrudRouteGenerator::defineDefaultRoutesExcept(['show'], 'id', 'dashboard');
    });

    Route::controller(AuthorController::class)->prefix('/authors')->name('authors.')->group(function () {
        CrudRouteGenerator::defineDefaultRoutesExcept(['show'], 'id', 'dashboard');
    });

    Route::controller(TermController::class)->prefix('/terms')->name('terms.')->group(function () {
        CrudRouteGenerator::defineDefaultRoutesExcept(['show'], 'id', 'dashboard');
    });

    Route::controller(PhotoController::class)->prefix('/photos')->name('photos.')->group(function () {
        CrudRouteGenerator::defineDefaultRoutesExcept(['show'], 'id', 'dashboard');
    });

    Route::controller(VideoController::class)->prefix('/videos')->name('videos.')->group(function () {
        CrudRouteGenerator::defineDefaultRoutesExcept(['show'], 'id', 'dashboard');
    });

    Route::controller(ChannelController::class)->prefix('/channels')->name('channels.')->group(function () {
        CrudRouteGenerator::defineDefaultRoutesExcept(['show'], 'id', 'dashboard');
    });

    Route::controller(CategoryController::class)->prefix('/categories/{model}')->name('categories.')->group(function () {
        CrudRouteGenerator::defineDefaultRoutesExcept(['trash', 'restore', 'show'], 'id', 'dashboard');

        Route::get('/edit-nestedset', 'editNestedset')->name('edit.nestedset');
        Route::post('/update-nestedset', 'updateNestedset')->name('update.nestedset');
    });

    Route::controller(UserController::class)->prefix('/users')->name('users.')->group(function () {
        CrudRouteGenerator::defineDefaultRoutesOnly(['index', 'edit', 'destroy'], 'id', 'dashboard');

        Route::patch('/update-password/{record}', 'updatePassword')->name('update.password');
        Route::patch('/toggle-inactive-role/{record}', 'toggleInactiveRole')->name('toggle.inactive-role');
    });

    Route::controller(FeedbackController::class)->prefix('/feedbacks')->name('feedbacks.')->group(function () {
        CrudRouteGenerator::defineDefaultRoutesOnly(['index', 'destroy'], 'id', 'dashboard');
    });
});
