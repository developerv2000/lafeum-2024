<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Helpers\UrlHelper;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard actions
    |--------------------------------------------------------------------------
    */

    public function dashboardIndex(Request $request)
    {
        User::addDashboardQueryParamsToRequest($request);
        UrlHelper::addUrlWithReversedOrderTypeToRequest($request);
        $records = User::finalizeQueryForDashboard(User::query(), $request, 'paginate');

        return view('dashboard.users.index', compact('records'));
    }
}
