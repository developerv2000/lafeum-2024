<?php

namespace App\Support\ViewComposerDefiners;

use App\Models\Author;
use App\Models\QuoteCategory;
use Illuminate\Support\Facades\View;

class DashboardViewComposersDefiner
{
    public static function defineAll()
    {
        self::defineQuotesComposers();
    }

    private static function defineViewComposer($views, array $data)
    {
        View::composer($views, function ($view) use ($data) {
            $view->with($data);
        });
    }

    private static function defineQuotesComposers()
    {
        self::defineViewComposer('dashboard.filters.quotes',[
            'authors' => Author::getAllMinified(),
            'categories' => QuoteCategory::getAllMinified(),
        ]);
    }
}
