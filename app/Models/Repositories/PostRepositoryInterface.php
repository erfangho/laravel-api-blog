<?php

namespace App\Models\Repositories;

interface PostRepositoryInterface
{
    public function postFilter($data);
    public function createPost($data);
    public function showPostById($id);
    public function updatePostById($id, $data);
    public function deletePostById($id);
}
