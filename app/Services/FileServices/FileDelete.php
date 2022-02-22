<?php

namespace App\Services\FileServices;

use Illuminate\Support\Facades\File;

class FileDelete
{
    public static function remove($data, $type)
    {
        if($type === "image"){
            File::delete("storage/uploads/images/".basename($data->image));
        }
        if($type === "thumbnail"){
            File::delete("storage/uploads/thumbnails/".basename($data->thumbnail));
        }
    }
}
