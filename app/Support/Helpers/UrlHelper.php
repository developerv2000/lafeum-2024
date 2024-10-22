<?php

namespace App\Support\Helpers;

use Illuminate\Http\Request;

class UrlHelper
{
    /**
     * Generates a URL with the reversed 'order_type' and removes 'order_by' from query parameters.
     *
     * @param Request $request
     * @return string The modified URL with reversed sorting order and without 'order_by'.
     */
    public static function generateUrlWithReversedOrderType(Request $request): string
    {
        // Get the existing query parameters from the request
        $queryParams = $request->query();

        // Remove 'order_by' if it exists
        GeneralHelper::removeArrayKey($queryParams, 'order_by');

        // Reverse the 'order_type' (toggle between 'asc' and 'desc')
        $queryParams['order_type'] = $request->get('order_type', 'asc') === 'asc' ? 'desc' : 'asc';

        // Build and return the URL with updated query parameters
        return $request->url() . '?' . http_build_query($queryParams);
    }
}
