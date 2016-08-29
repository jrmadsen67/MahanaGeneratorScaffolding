<?php

namespace jrmadsen67\MahanaScaffolding;

use Illuminate\Support\ServiceProvider;

class MahanaScaffoldingServiceProvider extends ServiceProvider {
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        $source = realpath(__DIR__ . '/../config/mahana-scaffolding.php');

        $this->publishes([
            $source => config_path('mahana-scaffolding.php'),
        ], 'mahana-scaffolding');

        $this->mergeConfigFrom($source, 'mahana-scaffolding');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('command.jrmadsen67.scaffolding-generate', function ($app) {
            return $app['jrmadsen67\MahanaScaffolding\Commands\GenerateScaffoldingCommand'];
        });

        $this->commands('command.jrmadsen67.scaffolding-generate');
    }


}
