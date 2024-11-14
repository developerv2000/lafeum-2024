<?php

namespace App\Support\ViewComposerDefiners;

use App\Models\Author;
use App\Models\QuoteCategory;
use App\Support\Helpers\ModelHelper;
use Illuminate\Support\Facades\View;

class DashboardViewComposersDefiner
{
    public static function defineAll()
    {
        self::paginationLimitComposer();
        self::defineQuotesComposers();
    }

    private static function defineViewComposer($views, array $data)
    {
        View::composer($views, function ($view) use ($data) {
            $view->with($data);
        });
    }

    private static function paginationLimitComposer()
    {
        self::defineViewComposer('components.dashboard.filters.partials.pagination-limit', [
            'paginationLimitOptions' => ModelHelper::getPaginationLimitOptions(),
        ]);
    }

    private static function defineQuotesComposers()
    {
        self::defineViewComposer('components.dashboard.filters.quotes', [
            'authors' => Author::getAllMinified(),
            'categories' => QuoteCategory::getAllMinified(),
        ]);
    }
}
