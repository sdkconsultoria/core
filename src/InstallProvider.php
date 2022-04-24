<?php

namespace Sdkconsultoria\Core;
use Illuminate\Database\Schema\Blueprint;

class InstallProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCommands();
        $this->registerMigrations();
        $this->registerMigrationsMacro();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Sdkconsultoria\Core\Console\Commands\MakePermissions::class,
                \Sdkconsultoria\Core\Console\Commands\MakeUser::class,
            ]);
        }
    }

    private function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    private function registerMigrationsMacro()
    {
        Blueprint::macro('commonFields', function () {
            $this->id();
            $this->genericFields();
        });

        Blueprint::macro('genericFields', function () {
            $this->statusField();
            $this->timestampsFields();
            $this->creatingFields();
        });

        Blueprint::macro('creatingFields', function () {
            $this->foreignId('created_by')->nullable()->constrained('users');
            $this->foreignId('updated_by')->nullable()->constrained('users');
            $this->foreignId('deleted_by')->nullable()->constrained('users');
        });

        Blueprint::macro('timestampsFields', function () {
            $this->timestamps();
            $this->timestamp('deleted_at')->nullable();
        });

        Blueprint::macro('statusField', function () {
            $this->smallInteger('status')->default('20');
        });

        Blueprint::macro('translatable', function () {
            $table = str_replace('_translates', '', $this->table);
            $table = Str::plural($table);
            $this->unsignedBigInteger('translatable_id');
            $this->foreign('translatable_id')->references('id')->on($table);
        });
    }
}
