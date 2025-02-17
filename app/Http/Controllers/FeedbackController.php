<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackStoreRequest;
use App\Models\Feedback;
use App\Support\Helpers\GeneralHelper;
use App\Support\Helpers\UrlHelper;
use App\Support\Traits\Controller\DestroysModelRecords;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    use DestroysModelRecords;

    public static $model = Feedback::class; // Required in multiple destroy/restore traits

    /*
    |--------------------------------------------------------------------------
    | Front actions
    |--------------------------------------------------------------------------
    */

    /**
     * Store the feedback submitted by the user.
     *
     * @param FeedbackStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FeedbackStoreRequest $request)
    {
        GeneralHelper::validateRecaptchaForRequest($request);
        Feedback::create($request->all());

        return redirect()->back();
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard actions
    |--------------------------------------------------------------------------
    */

    public function dashboardIndex(Request $request)
    {
        Feedback::addDashboardQueryParamsToRequest($request);
        UrlHelper::addUrlWithReversedOrderTypeToRequest($request);
        $records = Feedback::finalizeQueryForDashboard(Feedback::query(), $request, 'paginate');

        return view('dashboard.feedbacks.index', compact('records'));
    }
}
