<?php

namespace App\Services\FileServices;

use Illuminate\Support\Str;

class FileUpload
{
    private static $upload;
    public static function store($data, $type)
    {
        $upload = $data->store('uploads/'. Str::plural($type), 'public');
        self::$upload = $upload;
    }

    public static function getPath()
    {
        return 'storage/' . self::$upload;
    }
}
