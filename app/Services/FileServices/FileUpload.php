<?php

namespace App\Services\FileServices;

class FileUpload
{
    public static function store($data, $type)
    {
        $fileName = $data->getClientOriginalName();
        $upload = $data->storeAs('uploads/'. $type . 's', $fileName, 'public');
    }
}
