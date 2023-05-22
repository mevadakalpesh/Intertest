<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Http\RepoClass\ProductRepo;
use App\Http\RepoClass\UserRepo;

use App\Http\RepoInterface\ProductInterfaceRepo;
use App\Http\RepoInterface\UserInterfaceRepo;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProductInterfaceRepo::class,ProductRepo::class);
        $this->app->bind(UserInterfaceRepo::class,UserRepo::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
