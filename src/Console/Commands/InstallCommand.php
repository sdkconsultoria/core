<?php

namespace Sdkconsultoria\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdk:core-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Instala la libreria SDK';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->copyStubs();
        $this->writteUserChanges();
        $this->writteServiceProvider();

        $this->info('SDK Core se instalo correctamente.');
    }

    /**
     * Copia los stubs
     * @return void
     */
    private function copyStubs()
    {
        (new Filesystem)->ensureDirectoryExists(app_path('stubs'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/stubs', base_path('stubs'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/routes', base_path('routes'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/app', base_path('app'));
    }

    private function writteUserChanges()
    {
        copy(__DIR__.'/../../../stubs/models/User.php', base_path('app/Models/User.php'));
        copy(__DIR__.'/../../../stubs/factories/UserFactory.php', base_path('database/factories/UserFactory.php'));
    }

    private function writteServiceProvider()
    {
        $service_provider = "Sdkconsultoria\Core\ServiceProvider::class,";
        $file = base_path('config') . '/app.php';

        if(strpos(file_get_contents($file), $service_provider) !== false){
            return;
        }

        $package = "Package Service Providers...\n         */";
        $this->replaceInFile(
            $package,
            $package . "\n         $service_provider",
            $file);
    }

    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}