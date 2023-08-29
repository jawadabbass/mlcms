<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use RuntimeException;

class ErrorLogClearCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'errorlog:clear';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'errorlog:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear error log file';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new config clear command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \RuntimeException
     */
    public function handle()
    {
        $path = realpath(storage_path('debugbar'));
        if (!$path) {
            throw new RuntimeException('debugbar path not found.');
        }
        foreach ($this->files->glob("{$path}/*") as $file) {
            $this->files->delete($file);
        }

        /***************************** */
        
        $logFilePath = realpath(storage_path('logs/laravel.log'));
        if (!$logFilePath) {
            throw new RuntimeException('Error log path not found.');
        }
        $file = fopen($logFilePath, "w+");
        //echo fwrite($file, "");
        fclose($file);

        $this->components->info('Error log cleared successfully.');
    }
}
