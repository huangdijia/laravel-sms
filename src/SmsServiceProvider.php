<?php

namespace Huangdijia\Sms;

use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/sms.php' => $this->app->basePath('config/sms.php')], 'config');

            $this->commands([
                Console\InstallCommand::class,
                Console\SendCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->app->singleton(SmsManager::class, function ($app) {
            return new SmsManager($app);
        });
        $this->app->alias(SmsManager::class, 'sms');
    }

    public function provides()
    {
        return [
            SmsManager::class,
            'sms',
        ];
    }
}
