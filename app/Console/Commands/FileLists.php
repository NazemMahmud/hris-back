<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class FileLists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'list:appFiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List of all app directory files';

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
        $fileLists = Request::create(route('getFiles'), 'GET');
        $response = app()->handle($fileLists);
        $responseBody = json_decode($response->getContent(), true);
        $counter = 0;
        foreach ($responseBody as $file){
            $counter++;
            echo "File Path ".$counter." : ".$file."\n";
        }
//        $this->info($responseBody);
    }
}
