<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateByAdminRequest;
use App\Models\User;
use App\Support\Helpers\UrlHelper;
use App\Support\Traits\Controller\DestroysModelRecords;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use DestroysModelRecords;

    public static $model = User::class; // Required in multiple destroy trait

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

    public function dashboardEdit(Request $request, User $record)
    {
        return view('dashboard.users.edit', compact('record'));
    }

    public function updatePassword(PasswordUpdateByAdminRequest $request, User $record)
    {
        $record->updatePasswordByAdmin($request);

        return redirect($request->input('previous_url'));
    }

    public function toggleInactiveRole(Request $request, User $record)
    {
        $record->toggleInactiveRole();

        return redirect($request->input('previous_url'));
    }
}
