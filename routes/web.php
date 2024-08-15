<?php

use App\Http\Controllers\MainController;
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

    Route::controller(KnowledgeController::class)->prefix('/knowledge')->name('knowledge.')->group(function () {
        CrudRouteGenerator::defineDefaultCrudRoutesOnly(['index', 'showBySlug']);
    });

    Route::controller(VocabularyController::class)->prefix('/vocabulary')->name('vocabulary.')->group(function () {
        CrudRouteGenerator::defineDefaultCrudRoutesOnly(['index']);

        Route::get('/{category:slug}', 'category')->name('category');
        Route::get('/get-only-body/{record}', 'getBody')->name('get.only.body'); // AJAX search
    });

    Route::controller(QuoteController::class)->prefix('/quotes')->name('quotes.')->group(function () {
        CrudRouteGenerator::defineDefaultCrudRoutesOnly(['index', 'showByID']);

        Route::get('/{category:slug}', 'category')->name('category');
    });

    Route::controller(AuthorController::class)->prefix('/authors')->name('authors.')->group(function () {
        CrudRouteGenerator::defineDefaultCrudRoutesOnly(['index', 'showBySlug']);
    });

    Route::controller(VideoController::class)->prefix('/videos')->name('videos.')->group(function () {
        CrudRouteGenerator::defineDefaultCrudRoutesOnly(['index', 'showByID']);

        Route::get('/{category:slug}', 'category')->name('category');
    });

    Route::controller(ChannelController::class)->name('channels.')->prefix('/channels')->group(function () {
        CrudRouteGenerator::defineDefaultCrudRoutesOnly(['index', 'showBySlug']);
    });

    Route::controller(TermController::class)->prefix('/terms')->name('terms.')->group(function () {
        CrudRouteGenerator::defineDefaultCrudRoutesOnly(['index', 'showByID']);

        Route::get('/{category:slug}', 'category')->name('category');
    });

    Route::controller(PhotoController::class)->name('photos.')->prefix('/photos')->group(function () {
        CrudRouteGenerator::defineDefaultCrudRoutesOnly(['index']);
    });
});

require __DIR__ . '/auth.php';
