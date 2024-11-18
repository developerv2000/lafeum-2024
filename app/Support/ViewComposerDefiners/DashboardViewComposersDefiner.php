<?php

namespace App\Support\ViewComposerDefiners;

use App\Models\Author;
use App\Models\Knowledge;
use App\Models\QuoteCategory;
use App\Models\Term;
use App\Models\TermCategory;
use App\Models\TermType;
use App\Support\Helpers\GeneralHelper;
use App\Support\Helpers\ModelHelper;
use Illuminate\Support\Facades\View;

class DashboardViewComposersDefiner
{
    public static function defineAll()
    {
        self::paginationLimitComposer();
        self::defineQuotesComposers();
        self::defineTermsComposers();
    }

    private static function defineViewComposer($views, array $data)
    {
        View::composer($views, function ($view) use ($data) {
            $view->with($data);
        });
    }

    private static function paginationLimitComposer()
    {
        self::defineViewComposer('components.dashboard.filters.partials.pagination-limit-input', [
            'paginationLimitOptions' => ModelHelper::getPaginationLimitOptions(),
        ]);
    }

    private static function defineQuotesComposers()
    {
        self::defineViewComposer([
            'components.dashboard.filters.quotes',
            'dashboard.quotes.edit',
            'dashboard.quotes.create',
        ], [
            'authors' => Author::getMinifiedRecordsWithName(),
            'categories' => QuoteCategory::getMinifiedRecordsWithName(),
        ]);
    }

    private static function defineTermsComposers()
    {
        self::defineViewComposer([
            'components.dashboard.filters.terms',
            'dashboard.terms.edit',
            'dashboard.terms.create',
        ], [
            'namedTerms' => Term::getAllNamedRecordsMinified(),
            'types' => TermType::getMinifiedRecordsWithName(),
            'booleanOptions' => GeneralHelper::getBooleanOptionsArray(),
            'categories' => TermCategory::getMinifiedRecordsWithName(),
            'knowledges' => Knowledge::getMinifiedRecordsWithName(),
        ]);
    }
}
