<?php

namespace App\Models\Repositories;

use App\Events\PostCreated;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Repositories\PostRepositoryInterface;
use App\Services\FileServices\FileDelete;
use App\Services\FileServices\FileUpload;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class PostRepository implements PostRepositoryInterface
{
    public function postFilter($data)
    {
        $posts = Post::author($data->author_id)
                       ->fromto($data->from, $data->to)
                       ->date($data->date)->get();

        return Response()->json(PostResource::collection($posts), HttpFoundationResponse::HTTP_OK);
    }

    public function createPost($data)
    {
        FileUpload::store($data->file('image'), "image");
        $upload_image = FileUpload::getPath();
        FileUpload::store($data->file('thumbnail'), "thumbnail");
        $upload_thumbnail = FileUpload::getPath();
        $post = Post::create([
            "title" => $data->title,
            "author_id" => auth()->user()->id,
            "image" => $upload_image,
            "thumbnail" => $upload_thumbnail,
            "publish_time" => Carbon::now()->format('Y-m-d H:i:s'),
            "body" => $data->body,
        ]);

        event(new PostCreated($post));

        return Response()->json(["message" => __("messages.done")], HttpFoundationResponse::HTTP_OK);
    }

    public function showPostById($id)
    {
        $post = Post::findOrFail($id);

        return response()->json(new PostResource($post), HttpFoundationResponse::HTTP_OK);
    }

    public function updatePostById($id, $data)
    {
        $post = Post::findOrFail($id);

        if(! Gate::allows('update-post', $post))
        {
            return Response()->json(["message" => __("auth.unathorized")], HttpFoundationResponse::HTTP_UNAUTHORIZED);
        }

        if($data->has('image')){
            FileDelete::remove($post, "image");
            FileUpload::store($data->file('image'), "image");
            $post->image = FileUpload::getPath();
        }
        if($data->has('thumbnail')){
            FileDelete::remove($post, "thumbnail");
            FileUpload::store($data->file('thumbnail'), "thumbnail");
            $post->thumbnail  = FileUpload::getPath();
        }
        if($data->has('title')){
            $post->title = $data->title;
        }
        if($data->has('body')){
            $post->body  = $data->body;
        }

        $post->update();

        return Response()->json(["message" => __("messages.done")], HttpFoundationResponse::HTTP_OK);
    }

    public function deletePostById($id)
    {
        $post = Post::findOrFail($id);

        if(Auth::id() !== $post->author_id)
        {
            return Response()->json(["message" => __("auth.unathorized")], HttpFoundationResponse::HTTP_UNAUTHORIZED);
        }

        $post->delete();

        return Response()->json(["message" => __("messages.done")], HttpFoundationResponse::HTTP_OK);
    }
}

