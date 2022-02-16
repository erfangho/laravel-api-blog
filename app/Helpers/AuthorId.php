<?php

namespace App\Helpers;

use App\Models\Post;
use Illuminate\Http\Request;

class AuthorId extends PostFilter
{
    public function handle($posts, Request $request)
    {
        if($request->has('author_id')){
            $posts = $posts->where('author_id', $request->author_id);
        }
        $this->next($posts, $request);
    }
}
