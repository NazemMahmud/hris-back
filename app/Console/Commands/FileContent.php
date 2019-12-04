<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;

class FileContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file:getContent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get content of files after removing comments and empty lines';

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
        $fileLists = Request::create(route('getInfo'), 'GET');
        $response = app()->handle($fileLists);
        $responseBody = json_decode($response->getContent(), true);
        $counter = 0;
        foreach ($responseBody as $file){
            $counter++;
            echo $file."\n";
        }
    }
}
