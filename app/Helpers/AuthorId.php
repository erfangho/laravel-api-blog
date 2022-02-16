<?php

namespace App\Helpers;

use App\Models\Post;
use Illuminate\Http\Request;

class AuthorId extends PostFilter
{
    public function handle(Post $posts, Request $request)
    {
        $posts = new Post;
        if($posts->has('author_id')){
            $posts = $posts->where('author_id', $posts->author_id);
        }
        $this->next($posts, $request);
    }
}
