<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Post;
use Facade\FlareClient\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;


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


    public function store(Request $request)
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

        // basic web token
        // jwt
        // cookie authentication


        // now()
        // today()
        // Carbon

        $upload_image = $request->file('image')->store('uploads/images');
        $upload_thumbnail = $request->file('thumbnail')->store('uploads/thumbnails');

        $post = Post::create([
            "title" => $request->title,
            "author_id" => $request->author_id,
            "image" => asset("storage/{$upload_image}"),
            "thumbnail" => asset("storage/{$upload_thumbnail}"),
            "publish_time" => Carbon::now()->format('Y-m-d H:i:s'),
            "body" => $request->body,
        ]);

        return Response()->json(["message" => "Post succesfully created."], HttpFoundationResponse::HTTP_OK);
    }




    public function show($id)
    {
        //
        $post = Post::find($id);
        // findOrFail
        // Route binding
        return response()->json($post, HttpFoundationResponse::HTTP_OK);

    }


    public function update(Request $request, Post $post)
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
        try
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
            return Response()->json(["message" => "Post edited successfully."], HttpFoundationResponse::HTTP_OK);

        } catch(ModelNotFoundException $e) {
            return Response()->json(["message" => $e->getMessage()], HttpFoundationResponse::HTTP_NOT_FOUND);
        }

    }




    public function destroy($id)
    {

        try
        {
            $user = Post::findOrFail($id);
            $post = Post::find($id);
            File::delete("storage/uploads/images/".basename($post->image));
            File::delete("storage/uploads/thumbnails/".basename($post->thumbnail));
            $post->delete();
            return Response()->json(["message" => "Post succesfully deleted."], HttpFoundationResponse::HTTP_OK);
        }
        catch(ModelNotFoundException $e)
        {
            return Response()->json(["message" => $e->getMessage()], HttpFoundationResponse::HTTP_NOT_FOUND);
        }
    }
}
