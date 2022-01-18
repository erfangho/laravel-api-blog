<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Facade\FlareClient\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::all();
        return response()->json($post, HttpFoundationResponse::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $upload_image = $request->file('image')->store('uploads/images');
        $upload_thumbnail = $request->file('thumbnail')->store('uploads/thumbnails');
        $post = Post::create([
            "title" => $request->title,
            "author_id" => $request->author_id,
            "image" => asset("storage/{$upload_image}"),
            "thumbnail" => asset("storage/{$upload_thumbnail}"),
            "publish_time" => $request->publish_time,
            "body" => $request->body,
        ]);
        return "Successfuly added!";
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $posts = Post::where('id', '=', $id)->get();
        return response()->json($posts, HttpFoundationResponse::HTTP_OK);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $post = Post::find($id);
        $post->title = $request->title;
        //$post->title  = $request->author_id;
        $post->image = $request->image;
        $post->thumbnail  = $request->thumbnail;
        $post->publish_time  = $request->publish_time;
        $post->body  = $request->body;
        $post->save();
        return "successfuly updated";
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $post = Post::find($id);
        $post->delete();
        return 'sucess';
    }
}
