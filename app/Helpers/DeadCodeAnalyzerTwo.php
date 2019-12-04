<?php

namespace App\Helpers;

class DeadCodeAnalyzerTwo
{
    /**
     * @var
     * store classes, methods, interfaces separately
     */
    protected $checkFiles;

    /**
     * Initiate Check File keys
     */
    public function initiate(){
        $this->checkFiles['classes'] = array();
        $this->checkFiles['methods'] = array();
        $this->checkFiles['interfaces'] = array();
    }

    /**
     * @param $files
     */
    public function inspectFiles($files) {
        foreach ($files as $file){
            $fileName = $file;


        }

    }
}
