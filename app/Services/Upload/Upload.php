<?php

namespace App\Services\Upload;

use Illuminate\Support\Facades\File;
class Upload
{

    public static function store($data, $type)
    {
        $fileName = $data->getClientOriginalName();
        $upload = $data->storeAs('uploads/'. $type . 's', $fileName, 'public');
    }
}
