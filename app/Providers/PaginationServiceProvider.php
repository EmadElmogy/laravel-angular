<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class PaginationServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // This extension appends request query parameters to pagination links
        $query = array_except($this->app['request']->query(), ['page']);

        Paginator::currentPathResolver(function () use ($query) {
            return $this->app['request']->url()
            .($query ? '?' : '')
            .http_build_query($query);
        });

        Paginator::currentPageResolver(function ($pageName = 'page') {
            $page = $this->app['request']->input($pageName);

            if (filter_var($page, FILTER_VALIDATE_INT) !== false && (int) $page >= 1) {
                return $page;
            }

            return 1;
        });
    }
}
