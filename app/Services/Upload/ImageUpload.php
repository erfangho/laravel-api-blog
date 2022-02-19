<?php

namespace App\Services\Upload;

use Illuminate\Support\Facades\File;
class ImageUpload
{
    public $upload_image;
    public $upload_thumbnail;
    public function store($data)
    {
        $this->upload_image = $data->file('image')->store('uploads/images', 'public');
        $this->upload_thumbnail = $data->file('thumbnail')->store('uploads/thumbnails', 'public');
    }

    public function remove($post)
    {
        File::delete("storage/uploads/images/".basename($post->image));
        File::delete("storage/uploads/thumbnails/".basename($post->thumbnail));
    }
}
