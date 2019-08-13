<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Reference: https://tenancy.dev/docs/hyn/5.3/connections#forcing-the-connection
        // "This is also helpful for 3rd party packages models to force their connection to tenant."
        $env = app(\Hyn\Tenancy\Environment::class);

        if ($fqdn = optional($env->hostname())->fqdn) {
            config(['database.default' => 'tenant']);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // reference: https://github.com/Xethron/migrations-generator
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Way\Generators\GeneratorsServiceProvider::class);
            $this->app->register(\Xethron\MigrationsGenerator\MigrationsGeneratorServiceProvider::class);
        }
    }
}
