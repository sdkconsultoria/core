<?php

namespace Sdkconsultoria\Core\Console;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class MakePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdk:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea los roles y permisos';

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
        $this->createRoles();
        $this->createPermissions();

        return Command::SUCCESS;
    }

    protected function createRoles()
    {
        $roles = ['super-admin', 'admin', 'user'];

        foreach ($roles as $rol) {
            $this->findRoleOrCreate($rol);
        }
    }

    protected function getAllModels()
    {
        $models_files = [];
        $base_path = base_path();

        foreach ($this->folders() as $folder) {
            $this->info("Leyendo modelos desde $folder");
            $this->readModelsFromPath($base_path . $folder, $models_files);
        }

        return $models_files;
    }

    protected function folders(): array
    {
        return [
            '/vendor/sdkconsultoria/base/src/Models',
            '/vendor/sdkconsultoria/blog/src/Models',
            '/app/Models',
        ];
    }

    protected function readModelsFromPath(string $path, &$models_files)
    {
        if (file_exists($path)) {
            $files = scandir($path);
            unset($files[0]);
            unset($files[1]);

            foreach ($files as $file) {
                if (str_ends_with($file, '.php')) {
                    $models_files[] = $file;
                } else{
                    $this->readModelsFromPath("$path/$file", $models_files);
                }
            }

        }
    }

    protected function createPermissions()
    {
        $models = $this->getAllModels();
        $permisions = ['viewAny', 'view', 'create', 'update', 'delete', 'restore', 'forceDelete'];

        foreach ($models as $model) {
            $fixed_model = $this->fixedModel($model);

            foreach ($permisions as $permision) {
                $this->findPermissionOrCreate($fixed_model, $permision);
            }
        }
    }

    protected function fixedModel(string $model): string
    {
        $model_snake = Str::of($model)->snake();

        return str_replace('.php', '', $model_snake);
    }

    private function findRoleOrCreate(string $role): Role
    {
        return Role::firstOrCreate(['name' => $role]);
    }

    private function findPermissionOrCreate(string $model, string $permision): Permission
    {
        return Permission::firstOrCreate(['name' => "{$model}:{$permision}"]);
    }
}
