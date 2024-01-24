<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = '\\';

    public $HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group(['middleware' => 'web'], function () {

            Route::namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            Route::middleware('auth')
                ->namespace($this->namespace)
                ->group(base_path('module/CourseManagement/routes/web.php'));

            Route::middleware('auth')
                ->namespace($this->namespace)
                ->group(base_path('module/WebsiteCMS/routes/web.php'));

            Route::middleware('auth')
                ->namespace($this->namespace)
                ->group(base_path('module/UserAccess/routes/web.php'));

            Route::middleware('auth')
                ->namespace($this->namespace)
                ->group(base_path('module/ExamManagement/routes/web.php'));

            Route::middleware('auth')
                ->namespace($this->namespace)
                ->group(base_path('module/EnrollmentManagement/routes/web.php'));
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));

        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('module/WebsiteCMS/routes/api.php'));

        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('module/CourseManagement/routes/api.php'));

        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('module/ExamManagement/routes/api.php'));

        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('module/EnrollmentManagement/routes/api.php'));
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(3600)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
