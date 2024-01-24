<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Module\UserAccess\Models\Module;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                if (!session()->has('menuModules')) {
                    $modules = Module::active()->serialNoAsc()->get();
                    session()->put('menuModules', $modules);
                }
        
                if (!session()->has('slugs')) {
                    $slugs = auth()->user()->activePermissions()->pluck('slug')->toArray();
                    session()->put('slugs', $slugs);
                }
        
                if (!session()->has('activeModules')) {
                    $activeModules = session()->get('menuModules')->pluck('name')->toArray();
                    session()->put('activeModules', $activeModules);
                }
        
                // VIEW SHARE
                view()->share([
                    'slugs'         => session('slugs', []),
                    'activeModules' => session('activeModules', []),
                ]);
            } else {
                view()->share(['slugs' => [], 'activeModules' => []]);
            }
        });
        


        Str::macro('hasForeignKey', function ($table_name, $field_name) {
            $foreign_key_name = $table_name . '_' . $field_name . '_foreign';

            return count(DB::select(
                DB::raw(
                    'SHOW KEYS
                    FROM ' . $table_name . '
                    WHERE Key_name=\'' . $foreign_key_name . '\''
                )
            )) > 0;
        });


        Schema::defaultStringLength(191);


        Password::defaults(function () {
            return Password::min(8)->mixedCase()->uncompromised();
        });
    }
}
