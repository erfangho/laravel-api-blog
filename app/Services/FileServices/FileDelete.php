<?php

namespace App\Services\FileServices;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FileDelete
{
    public static function remove($data, $type)
    {
        File::delete('storage/uploads/'. Str::plural($type) .'/'.basename($data->$type));
    }
}
