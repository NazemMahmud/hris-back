<?php

namespace App\Helpers;

use App\Models\FileuploadHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FileuploadHelpers
{

    public function storeFile($fileArray)
    {
        $fileOriginalName = $fileArray->getClientOriginalName();
        $fileNameWithoutExtension = pathinfo($fileOriginalName, PATHINFO_FILENAME);
        $fileSize = $fileArray->getSize();
        $fileExt = $fileArray->getClientOriginalExtension();

        $path = 'files';
        $filePathName = $fileNameWithoutExtension . rand(123456789, 999999999) . time() . '.' . $fileExt;
        $fileArray->move($path, $filePathName);

        return $path . '/' . $filePathName;
    }

    public static function fileUpload($request)
    {

        $data = [];
        if ($request->hasFile('file_0')) {
            echo "file checked 0\n";
            $fileArray = $request->file('file_0');
            $data[] = (new self)->storeFile($fileArray);
//            return $fileArray->getClientOriginalName();
            /*foreach ($fileArray as $file) {
                return 'adadsaa sda dsa';
                $fileOriginalName = $file->getClientOriginalName();
                $fileNameWithoutExtension = pathinfo($fileOriginalName, PATHINFO_FILENAME);
                $fileSize = $file->getSize();
                $fileExt = $file->getClientOriginalExtension();

                $path = 'files';
                $filePathName = $fileNameWithoutExtension.rand(123456789, 999999999).time().'.'.$fileExt;
                $file->move($path, $filePathName);

                $file = new FileuploadHelper;
                $file->file_name = 'localhost:8000/'.$path.'/'. $filePathName;
                $file->file_extension = $fileExt;
                $file->file_size = $fileSize;
                $file->save();
                $data[] = [
                    'fileId' => $file->id,
                    'fileName' => $file->file_name];
            }*/
//            return ['data' => $data];
        }

        if ($request->hasFile('file_1')) {
            $fileArray = $request->file('file_1');
            $data[] = (new self)->storeFile($fileArray);
        }

        if ($request->hasFile('file_2')) {
            $fileArray = $request->file('file_2');
            $data[] = (new self)->storeFile($fileArray);
        }

        if ($request->hasFile('file_3')) {
            $fileArray = $request->file('file_3');
            $data[] = (new self)->storeFile($fileArray);
        }

        if ($request->hasFile('file_4')) {
            $fileArray = $request->file('file_4');
            $data[] = (new self)->storeFile($fileArray);
        }

        return $data;
    }
}
