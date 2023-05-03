<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class IncreaseApiVersion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:increase_version {current_version} {new_version}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Increase API version by copying the folder related to the API.';

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
     */
    public function handle(Filesystem $filesystem)
    {
        $appPath = app_path();
        $basePath = base_path();
        $currentApiVersion = $this->argument('current_version');
        $newApiVersion = str_replace('.', '_', $this->argument('new_version'));


        $apiFolders = [
            [
                'current' => $appPath . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Api' .  DIRECTORY_SEPARATOR . 'v' . $currentApiVersion,
                'new' => $appPath . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . 'Api' . DIRECTORY_SEPARATOR . 'v' . $newApiVersion,
                'type' => 'folder'
            ],
            [
                'current' => $appPath . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Requests' . DIRECTORY_SEPARATOR . 'Api' .  DIRECTORY_SEPARATOR . 'v' . $currentApiVersion,
                'new' => $appPath . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Requests' . DIRECTORY_SEPARATOR . 'Api' . DIRECTORY_SEPARATOR . 'v' . $newApiVersion,
                'type' => 'folder'
            ],
            [
                'current' => $appPath . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'Api' .  DIRECTORY_SEPARATOR . 'v' . $currentApiVersion,
                'new' => $appPath . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'Api' . DIRECTORY_SEPARATOR . 'v' . $newApiVersion,
                'type' => 'folder'
            ],
            [
                'current' => $appPath . DIRECTORY_SEPARATOR . 'Services' . DIRECTORY_SEPARATOR . 'Api' .  DIRECTORY_SEPARATOR . 'v' . $currentApiVersion,
                'new' => $appPath . DIRECTORY_SEPARATOR . 'Services' . DIRECTORY_SEPARATOR . 'Api' . DIRECTORY_SEPARATOR . 'v' . $newApiVersion,
                'type' => 'folder'
            ],
            [
                'current' => $basePath . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'api_v' .  $currentApiVersion . '.php',
                'new' => $basePath . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'api_v' . $newApiVersion . '.php',
                'type' => 'file'
            ],
        ];

        $copyOptions['copy_on_windows'] = true;

        foreach ($apiFolders as $folder) {
            if ($folder['type'] === 'folder') {
                $filesystem->mirror($folder['current'], $folder['new'], null, $copyOptions);
            } else {
                $filesystem->copy($folder['current'], $folder['new']);
            }
        }

        $routeServiceProviderFile = $appPath . DIRECTORY_SEPARATOR . 'Providers' . DIRECTORY_SEPARATOR . 'RouteServiceProvider.php';

        $newApiRouteCode = "Route::prefix('api/v" . $newApiVersion . "')
            \t->name('api.v" . $newApiVersion . ".')
            \t->namespace('App\\Http\\Controllers\Api\\v" . $newApiVersion . "')
            \t->middleware('api')
            \t->group(base_path('routes/api_v" . $newApiVersion . ".php'));

            // New API Version";

        $this->findAndReplace($routeServiceProviderFile, '// New API Version' ,$newApiRouteCode);

        $finder = new Finder();

        foreach ($apiFolders as $folder) {
            if ($folder['type'] === 'file') {
                continue;
            }

            $finder->files()->in($folder['new']);

            foreach ($finder as $file) {
                $absoluteFilePath = $file->getRealPath();

                $this->findAndReplace($absoluteFilePath, '\v' . $currentApiVersion . ';', '\v' . $newApiVersion . ';');
                $this->findAndReplace($absoluteFilePath, '\v' . $currentApiVersion . '\\', '\v' . $newApiVersion . '\\');
            }
        }
    }

    /**
     * @param $filename
     * @param $contentToReplace
     * @param $replaceWith
     */
    private function findAndReplace($filename, $contentToReplace, $replaceWith){
        $content = file_get_contents($filename);

        $content = str_replace($contentToReplace, $replaceWith, $content);

        file_put_contents($filename, $content);
    }
}
