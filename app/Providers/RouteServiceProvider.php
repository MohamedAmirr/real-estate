<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';
    protected $namespace = 'App/Http/Controllers';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::prefix('api/user')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/user_api.php'));

            Route::prefix('api/admin')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/admin_api.php'));
        });
    }

    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();

        $this->mapAdminRoutes();
        $this->mapUserRoutes();
    }

    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapAdminRoutes(): void
    {
        Route::middleware('admin')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin_api.php'));
    }

    protected function mapUserRoutes(): void
    {
        Route::prefix('user')->middleware('user')
            ->namespace($this->namespace)
            ->group(base_path('routes/user_api.php'));
    }
}
