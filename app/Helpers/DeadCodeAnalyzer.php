<?php

namespace App\Helpers;

use function foo\func;

define('EOL', "<br><br>");

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
    private $namespaceLists;
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
//                echo "ASShole{$i}:: ".$tokens[$i].EOL;
                $namespace = $tokens[$i]->getName();
//                $this->classStore($namespace);
//                echo "Namespace: ".$tokens[$i].":: ".$namespace."\n\n";
            } elseif ($tokens[$i] instanceof \PHP_Token_CLASS) {
//                echo "AShole{$i}:: ".$tokens[$i].EOL;
                $class = $tokens[$i]->getName();
                if ($namespace != '') {
                    $class = $namespace . DIRECTORY_SEPARATOR . $class;
                }
                $classFlag = 1;
            } elseif ($classFlag) {
                return $class;
            }
        }
        return $class;
    }

    /**
     * @param $files
     */
    public function storeFileInfo($files)
    {
        /********************** TEST CODE *********************************************/
        $all = app_path() . "\Http\Controllers\Setup\OrganizationBandController.php";
        $filess = [];
        $filess [] = $all;
        /********************** TEST CODE *********************************************/
        foreach ($filess as $filePath) {
//            $filee = file_get_contents(app_path() . DIRECTORY_SEPARATOR. "Helpers\\test.php");
            $namespace = $this->getNameSpace($filePath);
            if ($namespace)
                $this->classStore($namespace, $filePath);

        }
        /********************** TEST CODE *********************************************/
        $allClasses = $this->checkFiles['classes'];
        var_dump($allClasses);
//        foreach ($this->checkFiles['classes'] as $class) {
//            $filee = file_get_contents(app_path() . DIRECTORY_SEPARATOR. "Helpers\\test.php");
//            $namespace = $this->getNameSpace($filePath);
//            if ($namespace)
//                $this->classStore($namespace, $filePath);
//
//        }
        /********************** TEST CODE *********************************************/
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

    public function getMethodName($token)
    {
        print_r($token);
        echo "<br>";
    }

    public function getNamespaceLists($tokens, $totalToken){
        for ($item = 0; $item < $totalToken; $item++) {
            if($tokens[$item] == "use" && $tokens[$item+1] instanceof \PHP_Token_WHITESPACE &&
                ($tokens[$item+2] == "App" || ($tokens[$item+2] == "\\" && $tokens[$item+3] == "App" ))){ // only app directory namespace.
                $namespaceString = $replacedNamespaceString = "";
                for($itemCounter = $item + 2 ; $tokens[$itemCounter] != ";" ; $itemCounter++ ){
                    // wont store first separator in namespace AND no space will be concat in the namespace path
                    if( ($itemCounter == $item + 2 && $tokens[$itemCounter] == "\\" ) || $tokens[$itemCounter] == " ") continue;
                    if($tokens[$itemCounter] == "as"){
                        $replacedNamespaceString.= $tokens[$itemCounter+2];
                        echo "Replace !: ".$replacedNamespaceString.EOL;
                        break;
                    }
                    $namespaceString.=$tokens[$itemCounter];
                }
                echo "namespace::! ".$namespaceString.EOL;
                $item = $itemCounter;
                $this->namespaceLists [] = [
                    'namespace' => $namespaceString,
                    'replaced_namespace' => $replacedNamespaceString,
                ];
            }
            // if class starts then there will be no new namespace to add
            if($tokens[$item] == "class") break;
        }
        var_dump($this->namespaceLists);
        return true;
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
//        $classesToCheck = [];
        foreach ($files as $filePath) {
//            echo $filePath . " ASH HSSH <br>";
            $namespace = $this->getNameSpace($filePath);
            echo "<br><br>NAMESPACE:: " . $namespace . "<br><br>";
            $code = file_get_contents($filePath);
            $tokens = new \PHP_Token_Stream($code);
            /****************************  FOR TEST PURPOSE ***********************/
            /*
            $tokens = token_get_all($code);
            foreach ($tokens as $token) {
                if (is_array($token)) {
                    echo "Line {$token[2]}: ", token_name($token[0]), " ('{$token[1]}')", "<br><br>";
//                    if(token_name($token[0]) == T_OPEN_CU){ echo "WHATTTTT !!! YESS <br><br>"; }
                }
            }*/
            /****************************  FOR TEST PURPOSE ***********************/
            $totalToken = count($tokens);
            $classesToCheck = [];
            $usedClasses = $this->getNamespaceLists($tokens, $totalToken);
            /**
             * 1. From DI get Class and Object name/s to check
             * 2. From self:: [done]
             * 3. For static method or direct method call ==> ClassName::method()
             */
           /* for ($t = 0; $t < $totalToken; $t++) {
//                                echo "TokenI:: " . $tokens[$t] . EOL;
                 if ($tokens[$t] == "__construct") { // from constructor using DI get class name/s and object name/s
                     $classesToCheck [] = $this->getFromDI($tokens, $t);
                     foreach ($classesToCheck as $classes) {
                         foreach ($classes as $class)
                             echo "AAClass: " . $class['className'] . " Object: " . $class['object'] . "<br>";
                     }
                 }

                if ($tokens[$t] == "self" && $tokens[$t + 1] == "::") {
                    echo "TRUE<br>" . $tokens[$t + 2] . "<br><br>";
                    $this->selfMethodsCheck($namespace, $tokens[$t + 2]);
                    $t += 2;
                    continue;
                }

                if($tokens[$t] == "::" && $tokens[$t-1] != "self"){

                }


            }*/

//            $filee = file_get_contents(app_path() . DIRECTORY_SEPARATOR. "Helpers\\test.php");

            /*  if ($namespace) {
                  $class = new \ReflectionClass($namespace);
  //                echo "CLASS:: ".$class."\n\n";
                  $this->parentClass($class);
                  echo "ParentClassNamespace:: " . $this->parentClassNamespace . "<br><br>";
                  echo "ParentClassName:: " . $this->parentClassName . "<br><br>";
  //                $this->classStore($namespace, $filePath);
              }*/

            /*foreach ($tokens as $token) {
                for($i=0; $i< sizeof($token); $i++){
                    echo "Line: ".$i.":: ".$token[$i]."<br>";
                }
                $tokenName = token_name(intval($token[0]));
//                echo 'Token name:: '.$token[0][1]."<br><br>";
                if (is_array($token) && $tokenName == 'T_FUNCTION') {
                    echo "<br>Line {$token[2]}: ", token_name($token[0]), "::  ('{$token[1]}')", "</br>";
                }
            }*/

        }

        /**
         * get class objects from constructor
         * if there any
         */
        /*  $classesToCheck[] = $this->getFromConstructor($class);

          $methods = $class->getMethods();
          $functions = $this->getFunctions($class, $namespace);
          foreach ($functions as $fn){
              echo "Function name:: ".$fn['name']."<br><br>";
          }*/

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

    function classNameCheckFromNameSpace($className){

    }
    function getFromDI($tokens, $startPosition)
    {
        $classToCheck = [];
        $className = $objectString = "";
        $index = $startPosition;
        $paramFlag = $classFlag = $indexCounter = 0;
        while ($index) {
            $index++;
            if ($tokens[$index] == "}") { // It means end of constructor
                break;
            }
            if ($tokens[$index] == ")") { // end of constructor parameters
                $paramFlag = 1;
            }
            if (!$paramFlag) {
                // get class name
                if (!$classFlag && $tokens[$index] instanceof \PHP_Token_STRING) {
                    $className = $tokens[$index];
                    $classFlag++;
                }
                // get corresponding object name
                if ($classFlag && $tokens[$index] instanceof \PHP_Token_VARIABLE) {
                    $classFlag--;
                    $classToCheck [] = [
                        "className" => $className,
                        "object" => $tokens[$index]
                    ];
                }
            }
            // inside of the constructor
            if ($paramFlag) {
                $indexCounter = $index; // At first it indicates => "{"
                if ($tokens[$index] == '$this') { // here i dont have to think aboumt comments, bcoz if its a comment it will never get "$this"
                    $objectString .= $tokens[$index] . $tokens[$index + 1] . $tokens[$index + 2];
//                    $index = $index + 2;
                }
                if ($tokens[$index] instanceof \PHP_Token_VARIABLE && $tokens[$index] != '$this') { // because $this is also a variable
                    foreach ($classToCheck as $key => $value) {
                        if (!strcmp($classToCheck[$key]['object'], $tokens[$index])) {
                            $classToCheck[$key]['object'] = $objectString;
                            $objectString = "";
                        }
                    }
                }
            }
        }
        return $classToCheck;
//        foreach ($classToCheck as $classes){
//            echo "BB Class: ".$classes['className']." Object: ".$classes['object']."<br>";
//        }
    }

    function selfMethodsCheck($namespace, $selfMethodName)
    {
        $class = new \ReflectionClass($namespace);
        $className = $class->getShortName();
        $flag = 0;
        foreach ($this->checkFiles['classes'] as &$class) {
            if ($flag) break;
            if ($namespace == $class["namespace"] &&
                $className ==  $class["className"]) {
                foreach ($class["methods"] as &$method) {
                    if ($method["name"] == $selfMethodName) {
                        $flag = 1;
                        $method["flag"] = 1;
                        break;
                    }
                }
            }

        }
        var_dump($this->checkFiles);
    }

    /**
     * TESTING PART
     */

    function getFromConstructor($class)
    {
        $constructor = $class->getConstructor();
//        echo "Constructor class:: ".$constructor->class. "<br> <br>";
//        echo "Is equal:: ".($class->getName() === $constructor->class). " <br> <br>";
//            var_dump($constructor->getParameters());
        if ($class->getName() === $constructor->class) {
            $parameters = $constructor->getParameters();
            echo "Constructor Param:: " . $constructor->getNumberOfParameters() . "<br><br>";
            foreach ($parameters as $param) {
                echo "Param: <br>" . $param->name;
//                var_dump($param);
                echo "<br>";
                echo "Param: <br>" . $param->getType() . "<br>";
//                echo "Param: <br>";
            }

            echo "Constructor property check:: <br> <br>";
            var_dump($class->getConstructor()->__toString());
        }

        return [];
    }
}
