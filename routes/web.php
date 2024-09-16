<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VocabularyController;
use App\Support\Generators\CrudRouteGenerator;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest.or.verified'])->group(function () {
    Route::controller(MainController::class)->group(function () {
        Route::get('/', 'home')->name('home');
        Route::get('/about-us', 'aboutUs')->name('about.us');
        Route::get('/contacts', 'contacts')->name('contacts');
        Route::get('/privacy-policy', 'privacyPolicy')->name('privacy.policy');
        Route::get('/terms-of-use', 'termsOfUse')->name('terms.of.use');
    });

    Route::controller(FeedbackController::class)->prefix('/feedbacks')->name('feedbacks.')->group(function () {
        Route::post('/store', 'store')->name('store');
        CrudRouteGenerator::defineDefaultCrudRoutesOnly(['store']);
    });

    Route::controller(LikeController::class)->name('likes.')->prefix('/likes')->group(function () {
        Route::post('/toggle/{model}/{id}', 'toggle')->name('toggle'); // AJAX request
    });

    Route::controller(FavoriteController::class)->name('favorites.')->prefix('/favorites')->group(function () {
        Route::post('/refresh/{model}/{id}', 'refresh')->name('refresh'); // AJAX request
    });

    Route::controller(KnowledgeController::class)->prefix('/knowledge')->name('knowledge.')->group(function () {
        CrudRouteGenerator::defineDefaultCrudRoutesOnly(['index', 'showBySlug']);
    });

    Route::controller(VocabularyController::class)->prefix('/vocabulary')->name('vocabulary.')->group(function () {
        CrudRouteGenerator::defineDefaultCrudRoutesOnly(['index']);

        Route::get('/{category:slug}', 'category')->name('category');
        Route::post('/get-body', 'getBody')->name('get.body'); // AJAX search
    });

    Route::controller(QuoteController::class)->name('quotes.')->group(function () {
        Route::prefix('/quotes')->group(function () {
            CrudRouteGenerator::defineDefaultCrudRoutesOnly(['index']);
            Route::get('/{category:slug}', 'category')->name('category');
        });

        Route::prefix('/quote')->group(function () {
            CrudRouteGenerator::defineDefaultCrudRoutesOnly(['showByID']);
        });
    });

    Route::controller(AuthorController::class)->prefix('/authors')->name('authors.')->group(function () {
        CrudRouteGenerator::defineDefaultCrudRoutesOnly(['index']);

        // CrudRouteGenerator is not used because AuthorGroup can be used instead of Author
        Route::get('/{slug}', 'show')->name('show');
    });

    Route::controller(VideoController::class)->name('videos.')->group(function () {
        Route::prefix('/videos')->group(function () {
            CrudRouteGenerator::defineDefaultCrudRoutesOnly(['index']);
            Route::get('/{category:slug}', 'category')->name('category');
        });

        Route::prefix('/video')->group(function () {
            CrudRouteGenerator::defineDefaultCrudRoutesOnly(['showByID']);
        });
    });

    Route::controller(ChannelController::class)->name('channels.')->prefix('/channels')->group(function () {
        CrudRouteGenerator::defineDefaultCrudRoutesOnly(['index', 'showBySlug']);
    });

    Route::controller(TermController::class)->name('terms.')->group(function () {
        Route::prefix('/terms')->group(function () {
            CrudRouteGenerator::defineDefaultCrudRoutesOnly(['index']);
            Route::get('/{category:slug}', 'category')->name('category');
        });

        Route::prefix('/term')->group(function () {
            CrudRouteGenerator::defineDefaultCrudRoutesOnly(['showByID']);
        });
    });

    Route::controller(PhotoController::class)->name('photos.')->prefix('/photos')->group(function () {
        CrudRouteGenerator::defineDefaultCrudRoutesOnly(['index']);
    });
});

require __DIR__ . '/auth.php';
