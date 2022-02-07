<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Exception;
use \App\Debug\JsonDocApi;

/**
 * use JsonDocApi and the view 'debug.jsondoc-swagger' to generate docs/api/swagger.yaml
 */
class UpdateSwaggerFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:swagger';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "generate swagger document and save file to docs/api/swagger.yaml";

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
     * @return mixed
     */
    public function handle()
    {
      $jsonDocApi = new JsonDocApi();
      $swaggerContents = view('debug.jsondoc-swagger', compact('jsonDocApi'));
      file_put_contents( base_path('docs/api/swagger.yaml'), $swaggerContents );
    }
}