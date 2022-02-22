<?php

namespace App\Helpers\Filter;

use Illuminate\Http\Request;

class Author extends Filter
{
    public $final;
    public function handle($posts, Request $request)
    {
        if($request->has('author_id')){
            $posts = $posts->where('author_id', $request->author_id);
        }
        $this->final = $posts->get();
        $this->next($posts, $request);
    }
}
