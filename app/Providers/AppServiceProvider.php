<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // register
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Use bootstrap for paginator vendor
        Paginator::useBootstrap();

        // Set default language to Vietnamese
        config(['app.locale' => 'vi']);
        \Carbon\Carbon::setLocale('vi');
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        Livewire::addPersistentMiddleware([
            \App\Http\Middleware\HandleAuthorAdmin::class,
        ]);
    }
}
