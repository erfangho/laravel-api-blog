<?php

namespace App\Services\Upload;

class Upload
{
    public static function store($data, $type)
    {
        $fileName = $data->getClientOriginalName();
        $upload = $data->storeAs('uploads/'. $type . 's', $fileName, 'public');
    }
}
