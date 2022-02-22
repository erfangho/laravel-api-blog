<?php

namespace App\Models\Repositories;

use App\Events\PostCreated;
use App\Helpers\Filter\Author;
use App\Helpers\Filter\Date;
use App\Helpers\Filter\FromTo;
use App\Models\Post;
use App\Models\Repositories\PostRepositoryInterface;
use App\Services\Delete\Delete;
use App\Services\Upload\Upload;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class PostRepository implements PostRepositoryInterface
{
    public function postFilter($data)
    {
        $posts = new Post;
        $author = new Author();
        $date = new Date();
        $from = new FromTo();

        $author->setSuccessor($date);
        $date->setSuccessor($from);
        $author->handle($posts, $data);

        return Response()->json($from->final, HttpFoundationResponse::HTTP_OK);
    }

    public function createPost($data)
    {
        $upload_image = Upload::store($data->file('image'), "image");
        $upload_thumbnail = Upload::store($data->file('thumbnail'), "thumbnail");

        $post = Post::create([
            "title" => $data->title,
            "author_id" => auth()->user()->id,
            "image" => asset('storage/uploads/images/'.$data->file('image')->getClientOriginalName().''),
            "thumbnail" => asset('storage/uploads/thumbnails/'.$data->file('thumbnail')->getClientOriginalName().''),
            "publish_time" => Carbon::now()->format('Y-m-d H:i:s'),
            "body" => $data->body,
        ]);

        event(new PostCreated($post));

        return Response()->json(["message" => __("messages.done")], HttpFoundationResponse::HTTP_OK);
    }

    public function showPostById($id)
    {
        $post = Post::findOrFail($id);

        return response()->json($post, HttpFoundationResponse::HTTP_OK);
    }

    public function updatePostById($id, $data)
    {
        $post = Post::findOrFail($id);

        $upload_image = Upload::store($data->file('image'), "image");
        $upload_thumbnail = Upload::store($data->file('thumbnail'), "thumbnail");

        Delete::remove($post, "image");
        Delete::remove($post, "thumbnail");

        $post->title = $data->title;
        $post->image = asset('storage/uploads/images/'.$data->file('image')->getClientOriginalName().'');
        $post->thumbnail  = asset('storage/uploads/thumbnails/'.$data->file('thumbnail')->getClientOriginalName().'');
        $post->body  = $data->body;
        $post->save();

        return Response()->json(["message" => __("messages.done")], HttpFoundationResponse::HTTP_OK);
    }

    public function deletePostById($id)
    {
        $post = Post::findOrFail($id);

        Delete::remove($post, "image");
        Delete::remove($post, "thumbnail");

        $post->delete();

        return Response()->json(["message" => __("messages.done")], HttpFoundationResponse::HTTP_OK);
    }
}

