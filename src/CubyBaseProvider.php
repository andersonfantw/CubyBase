<?php
namespace CubyBase;

use Illuminate\Support\ServiceProvider;
use CubyBase\Common\Phone;
use CubyBase\Providers\EventServiceProvider;

class CubyBaseProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/phone.php' => config_path('CubyBase/phone.php'),
       ]);
    }

    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->bind('CubyBase\Common\Phone', function($app){
            return new Phone();
        });
        $this->mergeConfigFrom(__DIR__.'/../config/phone.php', 'phone');
    }
}
