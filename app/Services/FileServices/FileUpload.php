<?php

namespace App\Services\FileServices;

class FileUpload
{
    private static $upload;
    public static function store($data, $type)
    {
        $upload = $data->store('uploads/'. $type . 's', 'public');
        self::$upload = $upload;
    }

    public static function getPath()
    {
        return 'storage/' . self::$upload;
    }
}
