<?php

namespace App\Providers;

use App\Contracts\ProductServiceInterface;
use App\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * 
     * Регистрирует привязки интерфейсов к их реализациям.
     * Это позволяет использовать интерфейсы в конструкторах,
     * а Laravel автоматически внедрит нужную реализацию.
     */
    public function register(): void
    {
        // Привязываем интерфейс ProductServiceInterface к реализации ProductService
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
