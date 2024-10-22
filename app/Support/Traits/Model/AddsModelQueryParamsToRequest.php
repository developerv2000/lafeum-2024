<?php

namespace App\Support\Traits\Model;

use App\Support\Helpers\UrlHelper;
use Illuminate\Http\Request;

/**
 * Trait AddsModelQueryParamsToRequest
 *
 * This trait provides functionality for merging model query parameters into a request object.
 *
 * @package App\Support\Traits\Model
 */
trait AddsModelQueryParamsToRequest
{
    /**
     * Add models default query parameters like 'order_by', 'order_type' etc into the given request object.
     *
     * @param \Illuminate\Http\Request $request The request object to merge parameters into.
     * @return void
     */
    public static function AddModelQueryParamsToRequest(Request $request)
    {
        // Merge default querying parameters into the request
        $request->mergeIfMissing([
            'order_by' => static::DEFAULT_DASHBOARD_ORDER_BY,
            'order_type' => static::DEFAULT_DASHBOARD_ORDER_TYPE,
            'pagination_limit' => static::DEFAULT_DASHBOARD_PAGINATION_LIMIT,
            'reversed_order_url' => UrlHelper::generateUrlWithReversedOrderType($request),
        ]);
    }
}
