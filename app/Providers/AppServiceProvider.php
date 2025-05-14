<?php

namespace App\Providers;

use App\Models\MenuItem;
use App\Models\Permission;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\PermissionRegistrar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        app(PermissionRegistrar::class)->setPermissionClass(Permission::class);
        FacadesView::composer('*', function ($view) {
            $menuItems = MenuItem::where('menu_id', 1)->whereNull('parent_id')
                ->with('children')
                ->get();
            $view->with('menuItems', $menuItems);
        });
    }
}
