<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
     public function uploadFile($file, $subFolder)
    {
        $fileName = date('d-m-Y-H-i') . '_' . trim($file->getClientOriginalName());
        try {
            $uploaddir = trim(public_path() . DIRECTORY_SEPARATOR). trim($subFolder . DIRECTORY_SEPARATOR);
            $uploadfile = $uploaddir . $fileName;
            move_uploaded_file($file->getPathName(), $uploadfile);
            $data['filename'] = $fileName;
            $data['status'] = 1;
        } catch (\Exception $ex) {
            $data['error'] = $ex->getMessage();
            $data['status'] = 0;
        }
        return $data;
    }
}
