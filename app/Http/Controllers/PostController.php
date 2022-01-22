<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Post;
use Facade\FlareClient\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Illuminate\Support\Facades\File;
use DateTime;


class PostController extends Controller
{


    public function __construct()
    {
        // initialize
        //$this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::all();
        return response()->json($posts, HttpFoundationResponse::HTTP_OK);
    }


    public function create(Request $request)
    {

        //
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'image',
            'thumbnail' => 'image',
            'body' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }

        $dt = new DateTime();

        $upload_image = $request->file('image')->store('uploads/images');
        $upload_thumbnail = $request->file('thumbnail')->store('uploads/thumbnails');

        $post = Post::create([
            "title" => $request->title,
            "author_id" => $request->author_id,
            "image" => asset("storage/{$upload_image}"),
            "thumbnail" => asset("storage/{$upload_thumbnail}"),
            "publish_time" => $dt->format('Y-m-d H:i:s'),
            "body" => $request->body,
        ]);

        return Response()->json(["message" => "Post succesfully created."], HttpFoundationResponse::HTTP_OK);
    }




    public function show($id)
    {
        //
        $post = Post::find($id);
        return response()->json($post, HttpFoundationResponse::HTTP_OK);

    }


    public function edit(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'image' => 'image',
            'thumbnail' => 'image',
            'body' => 'required',
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }


        $post = Post::find($id);

        $upload_image = $request->file('image')->store('uploads/images');
        $upload_thumbnail = $request->file('thumbnail')->store('uploads/thumbnails');

        File::delete("storage/uploads/images/".basename($post->image));
        File::delete("storage/uploads/thumbnails/".basename($post->thumbnail));

        $post->title = $request->title;
        $post->image = asset("storage/{$upload_image}");
        $post->thumbnail  = asset("storage/{$upload_thumbnail}");
        $post->body  = $request->body;
        $post->save();

        return Response()->json(["message" => "Post succesfully updated."], HttpFoundationResponse::HTTP_OK);
    }




    public function delete($id)
    {
        //
        $post = Post::find($id);

        File::delete("storage/uploads/images/".basename($post->image));
        File::delete("storage/uploads/thumbnails/".basename($post->thumbnail));

        $post->delete();

        return Response()->json(["message" => "Post succesfully deleted."], HttpFoundationResponse::HTTP_OK);
    }
}
