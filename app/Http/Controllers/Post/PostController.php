<?php

namespace App\Http\Controllers\Post;


use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Post;
use Facade\FlareClient\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;


class PostController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $posts = Post::all();
        return response()->json($posts, HttpFoundationResponse::HTTP_OK);
    }


    public function store(PostRequest $request)
    {
        $upload_image = $request->file('image')->store('uploads/images', 'public');
        $upload_thumbnail = $request->file('thumbnail')->store('uploads/thumbnails', 'public');
        $post = Post::create([
            "title" => $request->title,
            "author_id" => auth()->user()->id,
            "image" => asset("storage/{$upload_image}"),
            "thumbnail" => asset("storage/{$upload_thumbnail}"),
            "publish_time" => Carbon::now()->format('Y-m-d H:i:s'),
            "body" => $request->body,
        ]);
        return Response()->json(["message" => __("messages.done")], HttpFoundationResponse::HTTP_OK);
    }


    public function show($id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post, HttpFoundationResponse::HTTP_OK);
    }


    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $upload_image = $request->file('image')->store('uploads/images');
        $upload_thumbnail = $request->file('thumbnail')->store('uploads/thumbnails');
        File::delete("storage/uploads/images/".basename($post->image));
        File::delete("storage/uploads/thumbnails/".basename($post->thumbnail));
        $post->title = $request->title;
        $post->image = asset("storage/{$upload_image}");
        $post->thumbnail  = asset("storage/{$upload_thumbnail}");
        $post->body  = $request->body;
        $post->save();
        return Response()->json(["message" => __("messages.done")], HttpFoundationResponse::HTTP_OK);
    }


    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        File::delete("storage/uploads/images/".basename($post->image));
        File::delete("storage/uploads/thumbnails/".basename($post->thumbnail));
        $post->delete();
        return Response()->json(["message" => __("messages.done")], HttpFoundationResponse::HTTP_OK);
    }
}
