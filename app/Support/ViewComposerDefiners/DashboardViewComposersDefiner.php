<?php

namespace App\Support\ViewComposerDefiners;

use App\Models\Author;
use App\Models\AuthorGroup;
use App\Models\Channel;
use App\Models\Country;
use App\Models\Gender;
use App\Models\Knowledge;
use App\Models\QuoteCategory;
use App\Models\Term;
use App\Models\TermCategory;
use App\Models\TermType;
use App\Models\VideoCategory;
use App\Support\Helpers\GeneralHelper;
use App\Support\Helpers\ModelHelper;
use Illuminate\Support\Facades\View;

class DashboardViewComposersDefiner
{
    public static function defineAll()
    {
        self::definePaginationLimitComposer();
        self::defineQuotesComposers();
        self::defineTermsComposers();
        self::defineVideosComposers();
        self::defineAuthorsComposers();
        self::defineUsersComposers();
    }

    private static function definePaginationLimitComposer()
    {
        View::composer('components.dashboard.filters.partials.pagination-limit-input', function ($view) {
            $view->with([
                'paginationLimitOptions' => ModelHelper::getPaginationLimitOptions(),
            ]);
        });
    }

    private static function defineQuotesComposers()
    {
        View::composer([
            'components.dashboard.filters.quotes',
            'dashboard.quotes.edit',
            'dashboard.quotes.create',
        ], function ($view) {
            $view->with([
                'authors' => Author::getMinifiedRecordsWithName(),
                'categories' => QuoteCategory::getMinifiedRecordsWithName(),
            ]);
        });
    }

    private static function defineTermsComposers()
    {
        View::composer([
            'components.dashboard.filters.terms',
            'dashboard.terms.edit',
            'dashboard.terms.create',
        ], function ($view) {
            $view->with([
                'namedTerms' => Term::getAllNamedRecordsMinified(),
                'types' => TermType::getMinifiedRecordsWithName(),
                'booleanOptions' => GeneralHelper::getBooleanOptionsArray(),
                'categories' => TermCategory::getMinifiedRecordsWithName(),
                'knowledges' => Knowledge::getMinifiedRecordsWithName(),
            ]);
        });
    }

    private static function defineVideosComposers()
    {
        View::composer([
            'components.dashboard.filters.videos',
            'dashboard.videos.edit',
            'dashboard.videos.create',
        ], function ($view) {
            $view->with([
                'channels' => Channel::getMinifiedRecordsWithName(),
                'categories' => VideoCategory::getMinifiedRecordsWithName(),
            ]);
        });
    }

    private static function defineAuthorsComposers()
    {
        View::composer([
            'components.dashboard.filters.authors',
            'dashboard.authors.edit',
            'dashboard.authors.create',
        ], function ($view) {
            $view->with([
                'groups' => AuthorGroup::getMinifiedRecordsWithName(),
            ]);
        });
    }

    private static function defineUsersComposers()
    {
        View::composer([
            'components.dashboard.filters.users',
            'dashboard.users.edit',
            'dashboard.users.create',
        ], function ($view) {
            $view->with([
                'genders' => Gender::getMinifiedRecordsWithName(),
                'countries' => Country::getMinifiedRecordsWithName(),
            ]);
        });
    }
}
