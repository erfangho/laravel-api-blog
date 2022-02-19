<?php

namespace App\Services\Upload;

class ImageUpload
{
    public $upload_image;
    public $upload_thumbnail;
    public function store($data)
    {
        $this->upload_image = $data->file('image')->store('uploads/images', 'public');
        $this->upload_thumbnail = $data->file('thumbnail')->store('uploads/thumbnails', 'public');
    }
}
