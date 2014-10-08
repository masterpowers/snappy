<?php namespace Snappy\Providers;

use Pusher;
use Illuminate\Support\ServiceProvider;

class PusherServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Pusher', function()
        {
            return new Pusher('dac165bd3bc889882eeb', '751b45bea9298d59b275', '91809');
        });
    }
}