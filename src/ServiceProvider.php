<?php

namespace Sdkconsultoria\Core;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'core');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
