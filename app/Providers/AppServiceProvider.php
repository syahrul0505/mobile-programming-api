<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

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
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        // $isHttps = env('IS_HTTPS', false);

        // if ($isHttps === true) {
        //     $this->app['request']->server->set('HTTPS', true);
        //     URL::forceScheme('https');
        // }

        // $this->app['request']->server->set('HTTPS', true);
        // URL::forceScheme('https');

        view()->composer('*', function (){
            // $orderTable = User::get();
            // // $orderTable = OrderPivot::get();
            // // dd($orderPivot);
            // View::share('order_table',$orderTable);
        });
    }
}
