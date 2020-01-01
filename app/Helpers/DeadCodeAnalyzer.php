<?php

namespace App\Helpers;

use function foo\func;

define('EOL', "<br>");

class DeadCodeAnalyzer
{
    /**
     * @var
     * store classes, methods, interfaces separately
     */
    protected $checkFiles;

    protected $parentClassNamespace;
    protected $parentClassName;
    protected $parents;
    protected $methods;
    private $namespaceLists;
    private $constructorEndTokenPosition;

    public $lastToken;
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
//        echo "path: ".$path.EOL;
        $out = [];
        $results = scandir($path);
        $blackLists = ($flag != "") ? $this->dirBlackListsToAnalyze : $this->dirBlackLists;
//        echo "Blacklists".EOL;
//        var_dump($blackLists);
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
//        var_dump($out);
        return $out;
    }

    public function parentClass($class)
    {
        $this->parents = [];
        if ($parent = $class->getParentClass()) {
            $this->parentClassNamespace = $parent->name;
            $parentClass = new \ReflectionClass($this->parentClassNamespace);
            $this->parentClassName = $parentClass->getShortName();

            $this->parents [] = [
                "parentClassNamespace" => $this->parentClassNamespace,
                "parentClassName" => $this->parentClassName
            ];
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
            'parentClasses' => $this->parents,
            'methods' => $functions,
            'interface' => [],
            'traits' => []
        ];
//        var_dump($this->checkFiles['classes']);
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
//        $all = app_path() . "\Http\Controllers\Setup\OrganizationBandController.php";
        $all = app_path() . "\User.php";
        $filess = [];
        $filess [] = $all;
        /********************** TEST CODE *********************************************/
        foreach ($files as $filePath) {
//            $filee = file_get_contents(app_path() . DIRECTORY_SEPARATOR. "Helpers\\test.php");
            $namespace = $this->getNameSpace($filePath);
            if ($namespace)
                $this->classStore($namespace, $filePath);

        }
        /********************** TEST CODE *********************************************/
        $allClasses = $this->checkFiles['classes'];
//        echo "dump" . EOL; // IMPORTANT PRINT LINE
//        var_dump($allClasses);
      /*  foreach ($this->checkFiles['classes'] as $class) {
            echo "This namespace: " . $class["namespace"] . EOL;
            if (isset($class["parentClasses"])) {
//                $result = json_decode($class["parentClasses"]);
//                $context = $result['context'];
                foreach ($class["parentClasses"] as $parent)
                    echo "This parentClassName namespace: " . $parent["parentClassNamespace"]. EOL;
            }
//            $filee = file_get_contents(app_path() . DIRECTORY_SEPARATOR. "Helpers\\test.php");
//            $namespace = $this->getNameSpace($filePath);
//            if ($namespace)
//                $this->classStore($namespace, $filePath);
//
        }*/
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
        /***********************************    MAIN PART   *********************************************************/
         $allFiles = $this->getAllAppDirectoryFiles(app_path(), 'analyze');
         $this->inspectFiles($allFiles);
 //        $this->staticAndInternalCheck($allFiles);
 //        $this->interfacePropertyCheck($allFiles);
 //        $this->externalCallCheck($allFiles);
//         return $allFiles;
        /********************************************************************************************/
        /***********************************    TEST PART   *********************************************************/
//        $files = app_path() . "\Models\Holiday\FixedHoliday.php";
        /*$files = app_path() . "\Http\Controllers\Setup\BankController.php";
        $all = [];
        $all [] = $files;
        $this->inspectFiles($all);*/

        $methodFlagCounter = 0;
//        foreach ($this->checkFiles["classes"] as $class){
        foreach ($this->checkFiles["classes"] as $class){
            foreach ($class["methods"] as $mm) {
//                $methodFlagCounter++;
                if (!$mm["flag"]) {
                    echo "Namespace: " . $class["namespace"] . ":: ";
                    echo "Class name: " . $class["className"] .":: ";
                    echo "Method name: " . $mm["name"] . EOL;
                    $methodFlagCounter++;
                }
            }
        }

        echo "Checked:::: ".$methodFlagCounter.EOL;
        /***********************************    TEST PART END   *********************************************************/
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

    /**
     * @param $tokens
     * @param $totalToken
     * @throws \ReflectionException
     * Get Namespace Lists of a class under observation
     * If any class namespace is replaces with as keyword, we can get the real class name and namespace from here
     */
    public function getNamespaceLists($tokens, $totalToken)
    {
        $this->namespaceLists = [];
        for ($item = 0; $item < $totalToken; $item++) {
            if ($tokens[$item] == "use" && $tokens[$item + 1] instanceof \PHP_Token_WHITESPACE &&
                ($tokens[$item + 2] == "App" || ($tokens[$item + 2] == "\\" && $tokens[$item + 3] == "App"))) { // only app directory namespace.
                $namespaceString = $replacedNamespaceString = "";
                for ($itemCounter = $item + 2; $tokens[$itemCounter] != ";"; $itemCounter++) {
                    // wont store first separator in namespace AND no space will be concat in the namespace path
                    if (($itemCounter == $item + 2 && $tokens[$itemCounter] == "\\") || $tokens[$itemCounter] == " ") continue;
                    if ($tokens[$itemCounter] == "as") {
                        $replacedNamespaceString .= $tokens[$itemCounter + 2];
                        break;
                    }
                    $namespaceString .= $tokens[$itemCounter];
                }

                $item = $itemCounter;
                $class = new \ReflectionClass($namespaceString);
                $this->namespaceLists [] = [
                    'namespace' => $namespaceString,
                    'className' => (strlen($replacedNamespaceString) > 0) ? $replacedNamespaceString : $class->getShortName(),
//                    'replaced_namespace' => $replacedNamespaceString,
                ];
            }
            // if class starts then there will be no new namespace to add
            if ($tokens[$item] == "class") break;
        }
    }

    function getRealClassName($className)
    {
        $replacedFlag = 0;
        foreach ($this->namespaceLists as $namespace) {
            // 1. count same class name koybar ase
            // 2.1. if > 2 then jetar replaced namespac nai oita return
            // 2.2.1. jodi 1tai hoy and replace thake tahole oita
            // 2.2.2. jodi 1tai hoy and replace na thake tahole oita
            if ($namespace["className"] == $className) {
                return [
                    "namespace" => $namespace["namespace"],
                    "className" => $namespace["className"]
                ];
            }
            /*if ($namespace["replaced_namespace"] == $className &&
                $namespace["className"] == $className) {
                echo "Replaced namespace: ".$namespace["namespace"]." ClassName: ".$namespace["className"].EOL;
                // namespace shoho return kortesi coz static method check er shomoy namespace diye oi file e jeno check korte pari
                return [
                    "namespace" => $namespace["namespace"],
                    "className" => $namespace["className"]
                ];
            }
            elseif($namespace["className"] == $className &&
                $namespace["replaced_namespace"] != $className){
//                if($namespace["replaced_namespace"] == "") {
                    echo "Original namespace: ".$namespace["namespace"]." ClassName: ".$namespace["className"].EOL;
                    return [
                        "namespace" => $namespace["namespace"],
                        "className" => $namespace["className"]
                    ];
//                }
//                else{
//                    echo "Replaced namespace: ".$namespace["namespace"]." ClassName: ".$namespace["className"].EOL;
//                    return [
//                        "namespace" => $namespace["namespace"],
//                        "className" => $namespace["className"]
//                    ];
//                }
            }*/
        }

    }

    function getFromDI($tokens, $startPosition)
    { // here should be another condition. if class not found namespacelist, then we wont check that class
        $classToCheck = [];
        $className = $objectString = "";
        $index = $startPosition;
        $paramFlag = $classFlag = $indexCounter = 0;
        while ($index) {
            $index++;
            if ($tokens[$index] == "}") { // It means end of constructor
                $this->constructorEndTokenPosition = $index;
                break;
            }
            if ($tokens[$index] == ")") { // end of constructor parameters
                $paramFlag = 1;
            }
            if (!$paramFlag) {
                // get class name
                if (!$classFlag && $tokens[$index] instanceof \PHP_Token_STRING) {
                    $className = $this->getRealClassName($tokens[$index]);
                    $classFlag++;
                }
                // get corresponding object name
                if ($classFlag && $tokens[$index] instanceof \PHP_Token_VARIABLE) {
                    $classFlag--;
                    // by any chance 2ta class er name same hote pare, but namespace hobe na, so unique identifier namespace lagbe
                    $classToCheck [] = [
                        "namespace" => $className["namespace"],
                        "className" => $className["className"],
                        "object" => $tokens[$index]
                    ];
                }
            }
            // inside of the constructor
            if ($paramFlag) {
                $indexCounter = $index; // At first it indicates => "{"
                if ($tokens[$index] == '$this') { // here i dont have to think aboumt comments, bcoz if its a comment it will never get "$this"
                    $objectString .= $tokens[$index] . $tokens[$index + 1] . $tokens[$index + 2];
                    $index = $index + 2;
                }
                if ($tokens[$index] instanceof \PHP_Token_VARIABLE && $tokens[$index] != '$this') {
                    // because $this is also a variable
                    foreach ($classToCheck as $key => $value) {
                        if (!strcmp($classToCheck[$key]['object'], $tokens[$index])) {
                            $classToCheck[$key]['object'] = $objectString;
                            $objectString = "";
                        }
                    }
                }
            }
        }
        /**
         * A work needs to be done here,
         * jodi constructor er vitore model er DI use na hoy,
         * tahole oita array theke remove korte hobe
         */
        return $classToCheck;
//        foreach ($classToCheck as $classes){
//            echo "BB Class: ".$classes['className']." Object: ".$classes['object']."<br>";
//        }
    }

    function updateMethodFlag($namespace, $methodName, $fromWhere)
    {
//        if($namespace == "")
//            echo "From: ".$fromWhere.EOL;
//        else
//            echo "Name: ".$namespace.EOL;
        // here is a problem, interface and parent class is not checked yet.
        // if class / namespace is in App directory: it is already chec because this->checkfiles only store none other than app directory files
        $class = new \ReflectionClass($namespace);
        $className = $class->getShortName();
        $flag = $thisClass = $parentClassCheck = 0;
        $parentNamespace = "";
        foreach ($this->checkFiles['classes'] as &$class) {
            if ($flag) break;
            if ($namespace == $class["namespace"] && $className == $class["className"]) {
//                echo "Inside namespace: ".$namespace.EOL;
                foreach ($class["methods"] as &$method) {
                    if ($method["name"] == $methodName && $method["flag"] == 0) {
                        $flag = 1;
                        $thisClass = 1;
                        $method["flag"] = 1;
                        // return namespace and method name which flag is set to 1; so that from classesTocheck make empty

//                        echo "Namespace: " . $class["namespace"] . ":: ";
//                        echo "Class name: " . $class["className"] .":: ";
//                        echo "Method name: " . $method["name"] . EOL;
//                        $methodFlagCounter++;


                        break;
                    }
                }
            }

        }
        if (!$thisClass) {
            // if this class is still = 0; that means method is not in this class, its in its parent classes,
            // either in parent, or in interfaces
            // go there, gooooooooooooooooooo
            foreach ($this->checkFiles['classes'] as &$file) {
                if ($namespace == $file["namespace"] && $file["parentClasses"] ) { // && $className == $file["className"]
                    foreach ($file["parentClasses"] as $parent ) {
//                        echo "In loop parent".$parent["parentClassNamespace"].EOL;
                        $parentNamespace .= $parent["parentClassNamespace"];
                    }
//                    echo "parent namespace: ".$parentNamespace.EOL;
                    $this->updateMethodFlag($parentNamespace, $methodName, "recursive call");
                    $thisClass = 1;
                    break;
                }

            }
        }
//        var_dump($this->checkFiles);
    }

    /*public function staticMethodsCheck($className, $methodName)
    {
        echo "Static Methods Check: ".$className.EOL;
        $class = $this->getRealClassName($className);
        echo "Before call from staticMethodsCheck: ".$class["namespace"].EOL;
        $this->updateMethodFlag($class["namespace"], $methodName);
    }*/

//    function backTrackMethodsCheck($classToCheck, $totalToken, $tokens){
// object or namespace = $object
    function backTrackMethodsCheck($classArrayToCheck, $objectOrNamespace, $methodName, $checker)
    {
//        echo "Backtrack call !".$objectOrNamespace." ".$checker.EOL;
        // $checker = [
        // Di method = DI,
        // only $this = this,
        // other = other ] ;
//        $classToCheck [] = [
//            "namespace" => $className["namespace"],
//            "className" => $className["className"],
//            "object" => $tokens[$index]
//        ];
        if ($checker == 'this') {
//            echo "Before call from backTrackMethodsCheck this: ".$objectOrNamespace.EOL;
            $this->updateMethodFlag($objectOrNamespace, $methodName, "backtrack-this");
        } else {
            foreach ($classArrayToCheck as &$class) {
//                echo "HERERERERE: " . $class["namespace"];
                if ($class['object'] == $objectOrNamespace) {
//                    echo "Before call from backTrackMethodsCheck class object: ".$class['namespace'].EOL;
                    $this->updateMethodFlag($class['namespace'], $methodName, "backtrack-class-object");
                }
            }
        }

        /*for($index = 0; $index < $totalToken; $index++){
            // for dependency injection object will be like, $this->sds->method(
            if($tokens[$index] == '$this' && $tokens[$index+1] == '->' && $tokens[$index+2] instanceof \PHP_Token_STRING){
                $obj = $tokens[$index].$tokens[$index+1].$tokens[$index+2];
            }
            // for new keyword, will be like, $object->method(
        }*/
    }

    public function checkNamespace($model){
        foreach ($this->namespaceLists as $namespace){
//            if($namespace["className"] == $model || $namespace["replaced_namespace"] == $model){
            if($namespace["className"] == $model){
                return [
                    "namespace" => $namespace["namespace"],
                    "check" => 1
                ];
            }
        }
        return [
            "namespace" => "",
            "check" => 0
        ];
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
//            echo $filePath . " ASH HSSH".EOL;
            /** GET ALL TOKENS **/
            $namespace = $this->getNameSpace($filePath);
//            echo "<br><br>NAMESPACE:: " . $namespace . "<br><br>";
// // IMPORTANT PRINT LINE
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
            $this->getNamespaceLists($tokens, $totalToken); // get used Classes from the file use namespaces
//            foreach ($this->namespaceLists as $list){
//                echo "List: namespace: ".$list["namespace"]. " listClass: ". $list["className"]. " replaced: ".$list["replaced_namespace"].EOL;
//            }
            /**
             * 1. From DI get Class and Object name/s to check
             * 2. From self:: [done]
             * 3. For static method or direct method call ==> ClassName::method()
             * 4. using new keyword (creating new object / instance of that class)
             * 5. for $this->>method()::: NOT DONE
             */
            for ($t = 0; $t < $totalToken; $t++) {
//                                echo "TokenI:: " . $tokens[$t] . EOL;
                // storing class and object from constructor i.e. Dependency injection
                if ($tokens[$t] == "__construct") { // from constructor using DI get class name/s and object name/s
                    $classesCheck [] = $this->getFromDI($tokens, $t);
                    foreach ($classesCheck as $classes) {
                        foreach ($classes as $class) {
                            $classesToCheck [] = [
                                "namespace" => $class["namespace"],
                                "className" => $class['className'],
                                "object" => $class['object']
                            ];
//                            echo "AAClass: " . $class['className'] . " Object: " . $class['object'] . "<br>"; // IMPORTANT PRINT LINE
                        }
                    }
                    /*foreach ($classesToCheck as $classes) {
                        foreach ($classes as $class)
                            echo "AAClass: " . $class['className'] . " Object: " . $class['object'] . "<br>";
                    }*/
                    $t = $this->constructorEndTokenPosition; // so that amar abar eshe consructor e dhukte na hoy,
                    // r egula variable o read korte na hoy
                }
                // self method call
                if ($tokens[$t] == "self" && $tokens[$t + 1] == "::") {
//                    echo "TRUE<br>" . $tokens[$t + 2] . "<br><br>"; // IMPORTANT PRINT LINE
//                    echo "Before call from for self: ".$namespace.EOL;
                    $this->updateMethodFlag($namespace, $tokens[$t + 2], "self method");
                    $t += 2;
                    continue;
                }

                // static method call
                if ($tokens[$t] == "::" && $tokens[$t - 1] != "self" &&
                    $tokens[$t + 1] instanceof \PHP_Token_VARIABLE && $tokens[$t + 2] == "(") {
                    // here classname needs
                    $nameSpace = ($tokens[$t - 1] == 'static') ? $namespace: "";
                    if($nameSpace == ""){
                        $nameSpaceResult = $this->checkNamespace($tokens[$t - 1]);
                        if($nameSpaceResult["check"])
                            $nameSpace = $nameSpaceResult->namespace;
                    }
                    if($nameSpace != "")
                        $this->updateMethodFlag($nameSpace, $tokens[$t + 1], "from-static");
                }

                // new object create check
                if ($tokens[$t] == "new" && $tokens[$t + 1] instanceof \PHP_Token_STRING && $tokens[$t + 2] == "(") {
                    $variable = $t;
                    while (!($tokens[$variable] instanceof \PHP_Token_VARIABLE)) {
                        $variable--;
                    }
                    $c = $this->getRealClassName($tokens[$t + 1]); //  If any class namespace is replaces with as keyword, we can get the real class name and namespace from here
                    $classesToCheck [] = [
                        "namespace" => $c["namespace"],
                        "className" => $c["className"],
                        "object" => $tokens[$variable]
                    ];
                }

                // now for backtrack method to method flag check the $classesToCheck array
                if ($tokens[$t] instanceof \PHP_Token_VARIABLE) {
//                    echo "Token Variable:: ".$tokens[$t].$tokens[$t+1].$tokens[$t+2].EOL;
                    $object = $method = $checker = "";

                    // for $this, from DI:: like, $this->bank->getResourceById(
                    if ($tokens[$t] == '$this' && $tokens[$t + 1] == '->' &&
                        $tokens[$t + 2] instanceof \PHP_Token_STRING && $tokens[$t + 3] == '->' &&
                        $tokens[$t + 4] instanceof \PHP_Token_STRING && $tokens[$t + 5] == '('
                    ) {
                        $object .= $tokens[$t] . $tokens[$t + 1] . $tokens[$t + 2];
                        $method .= $tokens[$t + 4];
                        $t = $t + 5;
                        $checker .= "DI";
//                        echo "DI ObjectWithMethod: ".$object."->".$method.EOL;
                    }
                    // for calling same class method using $this->totalFromPercentage(
                    elseif ($tokens[$t] == '$this' && $tokens[$t + 1] == '->' &&
                        $tokens[$t + 2] instanceof \PHP_Token_STRING && $tokens[$t + 3] == '('
                    ) {
                        echo "This: ".$namespace." ++ObjectWithMethod: ".$tokens[$t].$tokens[$t + 1].$tokens[$t + 2].$tokens[$t + 3].EOL;
                        $object .= $namespace;
                        $method .= $tokens[$t + 2];
                        $t = $t + 3;
                        $checker .= "this";
//                        if($tokens[$t].$tokens[$t + 1].$tokens[$t + 2].$tokens[$t + 3] == '$this->totalFromPercentage(')

                    } // another local variable for new keyword, like $variable->method(
                    elseif ($tokens[$t] != '$this' && $tokens[$t + 1] == '->' &&
                        $tokens[$t + 2] instanceof \PHP_Token_STRING && $tokens[$t + 3] == '('
                    ) {
                        $object .= $tokens[$t];
                        $method .= $tokens[$t + 2];
//                        $t = $t + 3;
                        $checker .= "other";
//                        echo "New ObjectWithMethod: ".$object."->".$method.EOL;
                    }

//                    if($tokens[$this->lastToken+1] == '->' && $tokens[$this->lastToken+2] instanceof \PHP_Token_STRING && $tokens[$this->lastToken+3] == '('){
                    // $object = $this->book(DI); $this ; $variable
                    // method = methodName
//                    echo "jjjjj" . EOL;
//                    foreach ($classesToCheck as $class) {
////                        foreach ($classes as $class)
//                        if (isset($class["namespace"]))
//                            echo "Name space:: " . $class["namespace"] . EOL;
//                    }
                    if($checker != "")
                         $this->backTrackMethodsCheck($classesToCheck, $object, $method, $checker);
//                    }
                }
            }
//            $this->backTrackMethodsCheck($classToCheck, $totalToken, $tokens);

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

    function classNameCheckFromNameSpace($className)
    {

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
