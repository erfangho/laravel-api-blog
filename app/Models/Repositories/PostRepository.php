<?php

namespace App\Models\Repositories;

use App\Models\Post;
use App\Models\Repositories\PostRepositoryInterface;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class PostRepository implements PostRepositoryInterface
{
    public function postFilter($data)
    {
        $posts = new Post;
        if($data->has('author_id')){
            $posts = $posts->where('author_id', $data->author_id);
        }
        if($data->has('date')){
            $datetime = new Carbon($data->date.' 00:00:00');
            $posts = $posts->whereDate('created_at', $datetime);
        }
        if($data->has('from')){
            $from = new Carbon($data->from.' 00:00:00');
            $to = new Carbon($data->to.' 00:00:00');
            $posts = $posts->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to);
        }
        return Response()->json($posts->get(), HttpFoundationResponse::HTTP_OK);
    }

    public function createPost($data)
    {

    }

    public function showPostById($id)
    {

    }

    public function updatePostById($id, $data)
    {

    }

    public function deletePostById($id)
    {

    }
}

