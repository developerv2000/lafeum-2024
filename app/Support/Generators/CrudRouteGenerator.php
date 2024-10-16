<?php

/**
 * @author Bobur Nuridinov <developerv2000@gmail.com>
 */

namespace App\Support\Generators;

use Illuminate\Support\Facades\Route;

/**
 * Class CrudRouteGenerator
 *
 * This class provides helper methods for generating default CRUD routes
 * inside grouped routes with a defined controller, prefix, and name.
 */
class CrudRouteGenerator
{
    /**
     * Get all default route names based on the identifier attribute used in the 'show' route.
     *
     * @param string $identifierAttribute The attribute to use for identifying records in the 'show' route (e.g., 'id' or 'slug').
     *                                     Use 'id' to generate routes that identify records by their numeric ID.
     *                                     Use 'slug' to generate routes that identify records by a unique slug.
     *                                     Defaults to 'id'.
     * @return array The array of default CRUD route names.
     */
    private static function getDefaultRouteNames($identifierAttribute = 'id')
    {
        // Default CRUD route names
        $routes = [
            'index',
            'create',
            'edit',
            'trash',
            'store',
            'update',
            'destroy',
            'restore',
        ];

        // Add the 'show' route based on the identifier attribute
        switch ($identifierAttribute) {
            case 'id':
                $routes[] = 'showByID';
                break;
            case 'slug':
                $routes[] = 'showBySlug';
                break;
        }

        return $routes;
    }

    /**
     * Define a specific CRUD route by its name.
     *
     * @param string $name The name of the route to define.
     * @return void
     */
    public static function defineRouteByName($name)
    {
        switch ($name) {
            case 'index':
                Route::get('/', 'index')->name('index');
                break;
            case 'create':
                Route::get('/create', 'create')->name('create');
                break;
            case 'showByID':
                Route::get('/{record}', 'show')->name('show');
                break;
            case 'showBySlug':
                Route::get('/{record:slug}', 'show')->name('show');
                break;
            case 'edit':
                Route::get('/edit/{record}', 'edit')->name('edit');
                break;
            case 'trash':
                Route::get('/trash', 'trash')->name('trash');
                break;
            case 'store':
                Route::post('/store', 'store')->name('store');
                break;
            case 'update':
                Route::patch('/update/{record}', 'update')->name('update');
                break;
            case 'destroy':
                Route::delete('/destroy', 'destroy')->name('destroy');
                break;
            case 'restore':
                Route::patch('/restore', 'restore')->name('restore');
                break;
        }
    }

    /**
     * Define all default CRUD routes, using 'id' as the default identifier attribute for the 'show' route.
     *
     * @param string $identifierAttribute The attribute to use for identifying records in the 'show' route ('id' or 'slug').
     * @return void
     */
    public static function defineAllDefaultRoutes($identifierAttribute = 'id')
    {
        // Get the default CRUD route names based on the identifier
        $defaultRoutes = self::getDefaultRouteNames($identifierAttribute);

        // Define all routes
        foreach ($defaultRoutes as $route) {
            self::defineRouteByName($route);
        }
    }

    /**
     * Define default CRUD routes, excluding the specified routes.
     *
     * @param array $excepts The routes to exclude from the definition.
     * @param string $identifierAttribute The attribute to use for identifying records in the 'show' route ('id' or 'slug').
     * @return void
     */
    public static function defineDefaultRoutesExcept($excepts = [], $identifierAttribute = 'id')
    {
        // Get the default CRUD route names
        $defaultRoutes = self::getDefaultRouteNames($identifierAttribute);

        // Filter out excluded routes
        $routes = array_diff($defaultRoutes, $excepts);

        // Define the remaining routes
        foreach ($routes as $route) {
            self::defineRouteByName($route);
        }
    }

    /**
     * Define only specific CRUD routes.
     *
     * @param array $only The routes to include in the definition.
     * @param string $identifierAttribute The attribute to use for identifying records in the 'show' route ('id' or 'slug').
     * @return void
     */
    public static function defineDefaultRoutesOnly($only = [], $identifierAttribute = 'id')
    {
        // Ensure that routes are correctly generated based on the identifier attribute
        $defaultRoutes = self::getDefaultRouteNames($identifierAttribute);

        // Define only the specified routes
        foreach ($only as $name) {
            if (in_array($name, $defaultRoutes)) {
                self::defineRouteByName($name);
            }
        }
    }
}
