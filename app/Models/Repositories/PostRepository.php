<?php

namespace App\Models\Repositories;

use App\Models\Post;
use App\Helpers\Filter\Author;
use App\Helpers\Filter\Date;
use App\Helpers\Filter\FromTo;
use App\Events\PostCreated;
use App\Models\Repositories\PostRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
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
        $upload_image = $data->file('image')->store('uploads/images', 'public');
        $upload_thumbnail = $data->file('thumbnail')->store('uploads/thumbnails', 'public');
        $post = Post::create([
            "title" => $data->title,
            "author_id" => auth()->user()->id,
            "image" => asset("storage/{$upload_image}"),
            "thumbnail" => asset("storage/{$upload_thumbnail}"),
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
        $upload_image = $data->file('image')->store('uploads/images');
        $upload_thumbnail = $data->file('thumbnail')->store('uploads/thumbnails');
        File::delete("storage/uploads/images/".basename($post->image));
        File::delete("storage/uploads/thumbnails/".basename($post->thumbnail));
        $post->title = $data->title;
        $post->image = asset("storage/{$upload_image}");
        $post->thumbnail  = asset("storage/{$upload_thumbnail}");
        $post->body  = $data->body;
        $post->save();
        return Response()->json(["message" => __("messages.done")], HttpFoundationResponse::HTTP_OK);
    }

    public function deletePostById($id)
    {
        $post = Post::findOrFail($id);
        File::delete("storage/uploads/images/".basename($post->image));
        File::delete("storage/uploads/thumbnails/".basename($post->thumbnail));
        $post->delete();
        return Response()->json(["message" => __("messages.done")], HttpFoundationResponse::HTTP_OK);
    }
}

