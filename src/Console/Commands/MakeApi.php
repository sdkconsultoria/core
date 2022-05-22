<?php

namespace Sdkconsultoria\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class MakeApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdk:api {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea una API SDK';

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
        $model = $this->argument('model');
        $this->createModel($model);
        $this->createController($model);
        // $this->fixController($model);
        // $this->fixController($model);
        $this->generateRoute($model);

        $this->info("Se creó correctamente el API {$model}.");
    }

    private function createModel(string $model)
    {
        Artisan::call("make:model {$model} -mf --test");
        $this->comment('Modelo Creado.');
    }

    private function createController(string $model)
    {
        Artisan::call("make:controller Api/{$model}Controller --model={$model} --api");
    }

    private function generateRoute(string $model)
    {
        $singular = Str::singular(Str::kebab($model));
        $route = '    Route::SdkApi(\'' . $singular . '\', ' . $model . 'Controller::class);';

        if (strpos(file_get_contents(base_path('routes/api.php')), $route) !== false) {
            return;
        }

        $this->replaceInFile(
            "->prefix('v1')->group(function () {",
            "->prefix('v1')->group(function () {\n" . $route,
            base_path('routes/api.php')
        );
    }

    // private function fixController(string $model)
    // {
    //     $controllers_path = app_path('Http/Controllers/Api/');

    //     $this->ensureFolderExist($controllers_path);

    //     $controller = app_path('Http/Controllers/' . $model . 'Controller.php');
    //     $new_controller = app_path('Http/Controllers/Api/' . $model . 'Controller.php');

    //     if (file_exists($new_controller)) {
    //         return;
    //     }

    //     $this->replaceInFile('App\Http\Controllers', 'App\Http\Controllers\Admin', $controller);

    //     rename($controller, $new_controller);
    // }

    protected function ensureFolderExist(string $folder)
    {
        if (! file_exists($folder)) {
            mkdir($folder);
        }
    }

    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
