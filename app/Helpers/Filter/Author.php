<?php

namespace App\Helpers\Filter;

use App\Models\Post;
use Illuminate\Http\Request;

class Author extends Filter
{
    public function handle($posts, Request $request)
    {
        if($request->has('author_id')){
            $posts = $posts->where('author_id', $request->author_id);
        }
        $this->next($posts, $request);
    }
}
