<?php

namespace App\Support\Traits\Model;

use App\Support\Helpers\UrlHelper;
use Illuminate\Http\Request;

trait AddsQueryParamsToRequest
{
    /**
     * Adds default ordering and pagination parameters to the given request object.
     *
     * @param \Illuminate\Http\Request $request The request object to merge parameters into.
     * @return void
     */
    public static function addQueryParamsToRequest(Request $request): void
    {
        // Determine if the request is from the dashboard context
        $isDashboard = $request->routeIs('dashboard.*');

        // Define default parameters based on context (dashboard or front-end)
        $defaultParams = [
            'order_by' => $isDashboard ? static::DEFAULT_DASHBOARD_ORDER_BY : static::DEFAULT_FRONT_ORDER_BY,
            'order_type' => $isDashboard ? static::DEFAULT_DASHBOARD_ORDER_TYPE : static::DEFAULT_FRONT_ORDER_TYPE,
            'pagination_limit' => $isDashboard ? static::DEFAULT_DASHBOARD_PAGINATION_LIMIT : static::DEFAULT_FRONT_PAGINATION_LIMIT,
            'reversed_order_url' => UrlHelper::generateUrlWithReversedOrderType($request),
        ];

        // Merge default parameters into the request if they are not already present
        $request->mergeIfMissing($defaultParams);
    }
}
