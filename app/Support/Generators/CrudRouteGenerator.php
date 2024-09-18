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
 * iside grouped routes with defined controller, prefix and name.
 */
class CrudRouteGenerator
{
    /**
     * Get all default route names.
     *
     * @return array The array of default route names.
     */
    private static function getDefaultRouteNames()
    {
        return [
            'index',
            'create',
            'showByID',
            'showBySlug',
            'edit',
            'trash',
            'store',
            'update',
            'destroy',
            'restore',
        ];
    }

    /**
     * Define a template route by name.
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
     * Define all default templated routes
     *
     * @return void
     */
    public static function defineAllDefaultRoutes()
    {
        // Define default routes
        $defaultRoutes = self::getDefaultRouteNames();

        // Define routes
        foreach ($defaultRoutes as $route) {
            self::defineRouteByName($route);
        }
    }

    /**
     * Define default templated routes, excluding specified routes.
     *
     * @param array $excepts The routes to exclude from the definition.
     * @return void
     */
    public static function defineDefaultRoutesExcept($excepts)
    {
        // Define default routes
        $defaultRoutes = self::getDefaultRouteNames();

        // Remove excluded routes
        $routes = array_diff($defaultRoutes, $excepts);

        // Define routes
        foreach ($routes as $route) {
            self::defineRouteByName($route);
        }
    }

    /**
     * Define default templated routes, including only specified routes.
     *
     * @param array $only The routes to include in the definition.
     * @return void
     */
    public static function defineDefaultRoutesOnly($only = [])
    {
        foreach ($only as $name) {
            self::defineRouteByName($name);
        }
    }
}
