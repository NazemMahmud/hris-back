<?php

namespace App\Helpers;

use function foo\func;

class DeadCodeAnalyzer
{
    /**
     * @var
     * store classes, methods, interfaces separately
     */
    protected $checkFiles;

    protected $parentClassNamespace;
    protected $parentClassName;
    protected $methods;
    /**
     * @var array
     * the folder and files which will be ignored for dead code checking
     */
    protected $dirBlackLists = array('Console', 'Exceptions', 'Controllers', 'Middleware', 'Providers');
    protected $dirBlackListsToAnalyze = array('Console', 'Exceptions', 'Middleware', 'Providers');
    protected $fileBlackLists = array('Helper', 'Kernel');

    /**
     * Initiate Check File keys
     */
    public function initiate()
    {
        $this->checkFiles['classes'] = array();
        $this->checkFiles['methods'] = array();
        $this->checkFiles['interfaces'] = array();

        $this->parentClassNamespace = '';
        $this->parentClassName = '';
    }

    /**
     * @param $path
     * @param string $flag
     * @return array
     * GET FILE PATHS AND RETURNS
     * RETURN FILES
     */
    public function getAllAppDirectoryFiles($path, $flag = '')
    {
//        echo "sadsadsa: ".$flag."\n\n";
        $out = [];
        $results = scandir($path);
        $blackLists = (isset($flag)) ? $this->dirBlackListsToAnalyze : $this->dirBlackLists;
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;
            $filename = $path . DIRECTORY_SEPARATOR . $result;
            if (is_dir($filename)) {
                if (in_array($result, $blackLists)) {
//                    echo "Result in array: ".$result."\n\n";
                    continue;
                }
//                else  echo "Result: ".$result."</br>";
                $out = array_merge($out, $this->getAllAppDirectoryFiles($filename));
            } else {
//                $out[] = substr($filename, 0, -4); get files without extension
                $ext = strtolower(substr($filename, -3));
                if ($ext === 'php')
                    $out[] = $filename;
            }
        }
//        dd($out);
        return $out;
    }

    public function parentClass($class)
    {
        if ($class->getParentClass()) {
            $this->parentClassNamespace = $class->getParentClass()->name;
            $parentClass = new \ReflectionClass($this->parentClassNamespace);
            $this->parentClassName = $parentClass->getShortName();
        }
    }

    /**
     * Get Functions of a Class
     */
    public function getFunctions($class, $namespace)
    {
        $methods = $class->getMethods();
        $functions = [];
        foreach ($methods as $method) {
            if ($method->class == $namespace && $method->name !== '__construct') {
                $functions[] = [
                    'name' => $method->name,
                    'flag' => 0
                ];
                /*    echo "Fn : " . $method->name . "-->\t\t";    echo "Fn class: " . $method->class . "<br>\n\n";*/
            }
        }

        return $functions;
    }

    public function classStore($namespace, $filePath)
    {
        $class = new \ReflectionClass($namespace);
        $this->parentClass($class);

//        echo "parent:: ". $this->parentClassNamespace. "-->\t\t". $this->parentClassName." <br>\n\n";
        /*  echo "namespace:: ".$namespace."<br>\n\n";*/
//        $myFile = fopen()
       /* $file = 'myReport.txt';
        $destinationPath = base_path() . "/myReport/";
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        File::put($destinationPath . $file, $data);*/
//        return response()->download($destinationPath . $file);
        $methods = $class->getMethods();
        $functions = $this->getFunctions($class, $namespace);
        $this->checkFiles['classes'][] = [
            'namespace' => $namespace,
            'className' => $class->getShortName(),
            'isInterface' => $class->isInterface(),
            'isTrait' => $class->isTrait(),
            'parentClassNameSpace' => $this->parentClassNamespace,
            'parentClassName' => $this->parentClassName,
            'methods' => $functions
        ];
//        var_dump($this->checkFiles['classes']);
//        echo "<br><br>";
    }

    public function getNameSpace($file)
    {
        $tokens = new \PHP_Token_Stream($file);
        $count = count($tokens);
        $namespace = $class = '';
        $classFlag = 0;
        for ($i = 0; $i < $count; $i++) {
            if ($tokens[$i] instanceof \PHP_Token_NAMESPACE) {
                $namespace = $tokens[$i]->getName();
//                $this->classStore($namespace);
//                echo "Namespace: ".$tokens[$i].":: ".$namespace."\n\n";
            } elseif ($tokens[$i] instanceof \PHP_Token_CLASS) {
                $class = $tokens[$i]->getName();
                if ($namespace != '') {
                    $class = $namespace . DIRECTORY_SEPARATOR . $class;
                }
                $classFlag = 1;
            } elseif ($classFlag) {
                break;
            }
        }
        return $class;
    }

    /**
     * @param $files
     */
    public function storeFileInfo($files)
    {
        foreach ($files as $filePath) {
//            $filee = file_get_contents(app_path() . DIRECTORY_SEPARATOR. "Helpers\\test.php");
            $namespace = $this->getNameSpace($filePath);
            if ($namespace)
                $this->classStore($namespace, $filePath);

        }
        /*  $tokens = token_get_all($filee);
          $commentTokens = FileHelpers::commentTokens();
          $counter = 0;*/
        /* foreach ($tokens as $token){
             $tokenName =  token_name(intval($token[0]));
             if( $tokenName == 'T_NAMESPACE')
                 echo "Token nameee: ". $tokenName.":: ". $token[1]->getName()."\n\n";
 //                echo "Token nameee: ". token_name(intval($token[0]))."</br>\n\n";
 //                if (in_array($token[0], $commentTokens)) {
 //                    echo "Line {$token[2]}: ", token_name($token[0]), " ('{$token[1]}')","</br>";
 //                    continue;
 //                }
 //                $token = $token[1];
         }*/

        /* foreach ($files as $file){
             $fileName = $file;
 //            $codes =  file_get_contents($file);

             /**
              * 1. get namespace of that file using tokenizer
              * 2. use Reflection API (using that namespace) to get
              * class name, interface name, extends name if there, functions name [including static]


         }*/
    }

    public function getDeadCodes()
    {
        // MAIN PART
       /* $allFiles = $this->getAllAppDirectoryFiles(app_path(), 'analyze');
        $this->inspectFiles($allFiles);
//        $this->staticAndInternalCheck($allFiles);
//        $this->interfacePropertyCheck($allFiles);
//        $this->externalCallCheck($allFiles);
        return $allFiles;*/

       // TESTING PART
//        $files = app_path() . "\Models\Holiday\FixedHoliday.php";
        $files = app_path() . "\Http\Controllers\Setup\OrganizationBandController.php";
        $all = [];
        $all [] = $files;
//        dd($all);
        $this->inspectFiles($all);
    }

    public function staticAndInternalCheck($files)
    {

    }

    public function interfacePropertyCheck($files)
    {

    }

    public function externalCallCheck($files)
    {

    }

    /**
     * @param $files
     * @throws \ReflectionException
     * from here inspection will start
     */
    public function inspectFiles($files)
    {
        /**
         * MAIN PART
         */
        $classesToCheck = [];
        foreach ($files as $filePath) {
            echo $filePath." ASH HSSH <br>";
//            $filee = file_get_contents(app_path() . DIRECTORY_SEPARATOR. "Helpers\\test.php");
            $namespace = $this->getNameSpace($filePath);
            echo "NAMESPACE:: ".$namespace."<br><br>";
            if ($namespace) {
                $class = new \ReflectionClass($namespace);
//                echo "CLASS:: ".$class."\n\n";
                $this->parentClass($class);
                echo "ParentClassNamespace:: ".$this->parentClassNamespace."<br><br>";
                echo "ParentClassName:: ".$this->parentClassName ."<br><br>";
//                $this->classStore($namespace, $filePath);
            }

            /**
             * get class objects from constructor
             * if there any
             */
            $classesToCheck[] = $this->getFromConstructor($class);

            $methods = $class->getMethods();
            $functions = $this->getFunctions($class, $namespace);
            foreach ($functions as $fn){
                echo "Function name:: ".$fn['name']."<br><br>";
            }

          /*  $this->checkFiles['classes'][] = [
                'namespace' => $namespace,
                'className' => $class->getShortName(),
                'isInterface' => $class->isInterface(),
                'isTrait' => $class->isTrait(),
                'parentClassNameSpace' => $this->parentClassNamespace,
                'parentClassName' => $this->parentClassName,
                'methods' => $functions
            ];*/

        }

      /**
       * TESTING PART
       */
    }

    public function getFromConstructor($class){
        $constructor = $class->getConstructor();
//        echo "Constructor class:: ".$constructor->class. "<br> <br>";
//        echo "Is equal:: ".($class->getName() === $constructor->class). " <br> <br>";
//            var_dump($constructor->getParameters());
        if ($class->getName() === $constructor->class){
            $parameters = $constructor->getParameters();
            echo "Constructor Param:: ".$constructor->getNumberOfParameters()."<br><br>";
            foreach ($parameters as $param){
                echo "Param: <br>". $param->name;
//                var_dump($param);
                echo "<br>";
                echo "Param: <br>". $param->getType()."<br>";
//                echo "Param: <br>";
            }

            echo "Constructor property check:: <br> <br>";
            var_dump($class->getConstructor()->__toString());
        }

        return [];
    }
}
