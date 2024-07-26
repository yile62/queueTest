<?php
namespace App\Providers;

use Illuminate\Redis\RedisServiceProvider as BaseRedisServiceProvider;
use Illuminate\Redis\RedisManager;
use Predis\Client;

class PredisServiceProvider extends BaseRedisServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('redis', function ($app) {
            $config = $app->make('config')->get('database.redis');

            return new RedisManager($app, 'predis', $config);
        });

        $this->app->bind('redis.connection', function ($app) {
            return $app['redis']->connection();
        });
    }
}
