<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::prefix('api')
                 ->middleware('api')
                 ->group(base_path('routes/api.php'));

            // Auto-load module routes
            foreach (glob(app_path('Modules/*/Routes/api.php')) as $file) {
                Route::prefix('api')
                     ->middleware('api')
                     ->group($file);
            }
        });
    }
}
