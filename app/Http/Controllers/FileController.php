<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Helpers\DeadCodeAnalyzer;

class FileController extends Controller
{
    private $dramas;
    /**
     * store all file paths, here only for app directory
     */
    protected $allAppFiles;

    /**
     * @var
     * helper such as for dead code, long method
     */
    protected $helper;

    public function __construct()
    {
//        $this->dramas = $dramas; Drama $dramas
//        $this->middleware('auth:admin');
    }

    /**
     * @param $path
     * @return array
     */
    public function getAllAppDirectoryFiles($path)
    {
        $out = [];
        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;
            $filename = $path . DIRECTORY_SEPARATOR . $result;
            if (is_dir($filename)) {
                $out = array_merge($out, $this->getAllAppDirectoryFiles($filename));
            } else {
//                $out[] = substr($filename, 0, -4); get files without extension
                $ext = strtolower(substr($filename, -3));
                if ($ext === 'php')
                    $out[] = $filename;
            }
        }
        return $out;
    }

    /**
     * @return array
     * get file path lists and store
     */
    public function getFileLists()
    {
        $this->allAppFiles = array();
        $this->allAppFiles = $this->getAllAppDirectoryFiles(app_path());
//        dd($files);
        return $this->allAppFiles;
    }

    public function findDeadCodes()
    {
        $this->helper = new DeadCodeAnalyzer();
        $allFiles = $this->helper->getAllAppDirectoryFiles(app_path());
        $this->helper->initiate();
        $this->helper->storeFileInfo($allFiles);
        $result = $this->helper->getDeadCodes();
//        return $allFiles;
    }

    public Function index()
    {
//        $files = $this->getAllAppDirectoryFiles(app_path());
        $file = [];
        $methodStart = 0;
        $methodend = 0;
        $commentStart = 0;
        // remove all blank lines
        // remove all comments (single / multi / doc)
        // tokenizer // lexical analysis
        $newStr = $lines = '';
        $files = file_get_contents(app_path() . "/Drama.php");
//        $commentTokens = $this->commentTokens();

        $tokens = token_get_all($files);
        $counter = 0;
        foreach ($tokens as $token) {
            $counter++;
            if (is_array($token)) {
//                echo "Token name: ". token_name($token[0])."</br>\n\n";
//                if (in_array($token[0], $commentTokens)) {
                echo "Counter:: ".$counter." Line {$token[2]}: ", token_name($token[0]), " ('{$token[1]}')","</br>";
//                    continue;
//                }
//                $token = $token[1];
            }
//            $newStr .= $token;
            /*   if (strstr($token, "\n")) {
                   if ((!empty(trim($lines))))
                       $file[] = trim($lines); // trim kore whitespace gula remove kora hoy; majhe majhe only space theke jay i.e. empty string/blank line
                   $lines = "";
               } else {
                   $lines .= $token;
               }*/
        }
//        dd ($file);
        return $file;
//        return 'dada';
    }

    public function readContent()
    {
        // remove all blank lines
        // remove all comments (single / multi / doc)
        // tokenizer // lexical analysis
//        $files = app_path() . DIRECTORY_SEPARATOR. "Drama.php";
        $files =  $files = file_get_contents(app_path() . "/Drama.php");;
        $tokens = token_get_all($files);
//        var_dump($tokens);
        foreach ($tokens as $token) {
            if (is_array($token)) {
//                if (in_array($token[0], $commentTokens)) {
                echo "Line {$token[2]}: ", token_name($token[0]), " ('{$token[1]}')","</br>";
//                    continue;
//                }
//                $token = $token[1];
            }
//            $newStr .= $token;
            /*   if (strstr($token, "\n")) {
                   if ((!empty(trim($lines))))
                       $file[] = trim($lines); // trim kore whitespace gula remove kora hoy; majhe majhe only space theke jay i.e. empty string/blank line
                   $lines = "";
               } else {
                   $lines .= $token;
               }*/
        }

        // get class name
        /*  $class = new ReflectionClass("\\App\\Books");
          $methods = $class->getMethods();
          $functions = get_defined_functions();
          foreach ($methods as $method){
              echo "method:: ".$method->getFileName()."</br>";
          }
          echo "file name:: ". $class->getFileName(); */

        /*  $decClasses = get_declared_classes();
           foreach ($decClasses as $class) {
               $class = new ReflectionClass($class);
   //            echo "ffff " . realpath(app_path() . DIRECTORY_SEPARATOR . "Drama.php") . "</br>";
               echo "fff " . $class->getName() . "</br>";
              /* if ($class->getFileName() === realpath($files)) {
                   echo "asdad " . $class->getName() . "</br>";
   //            $classes[] = $class->getName();
               }
           }*/


        /* $functs = array();
         $functions = get_defined_functions();
         foreach ($functions['user'] as $func) {
             $func = new ReflectionFunction($func);
             echo "aaa : ".$func->getFileName()."</br>";
             if ($func->getFileName() == realpath($files)) {
                 echo "aaa : ".$func->getName()."</br>";
                 $functs[] = $func->getName();
             }
         }*/


//        $fileHelper = new FileHelpers();
//        $file = $fileHelper->removeComments($files);
//        return $file;
    }

    public function fileRead()
    {
        //        $files = $this->getAllAppDirectoryFiles(app_path());
//        $files = array_diff(scandir(app_path()), array('..', '.'));
        $files = file(app_path() . "/Drama.php");
        $file = [];
        // remove all blank lines
        foreach ($files as $line) {
            $ss = trim($line);
            if (!empty($ss)) {
                $file[] = $ss;
                echo $line . "\n<br/>";
            }
        }

        //   $files = File::files(app_path()); $directories = File::directories(app_path())
        dd($file);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = $this->dramas->getGenreList();
        return view('admin.drama.create')->with('genres', $genres);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'genre_id' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->messages()]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $result = $this->dramas->storeResource($request);

        if ($result['error']) return redirect()->back()->withErrors($result['validator'])->withInput();
        else return redirect()->route('dramas');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Drama $drama
     * @return \Illuminate\Http\Response
     */
    public function show(Drama $drama)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Drama $drama
     * @return \Illuminate\Http\Response
     */
    public function edit(Drama $drama)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Drama $drama
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Drama $drama)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Drama $drama
     * @return \Illuminate\Http\Response
     */
    public function destroy(Drama $drama)
    {
        //
    }
}
