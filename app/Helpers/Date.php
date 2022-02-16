<?php

namespace App\Helpers;

use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Date extends PostFilter
{
    public function handle(Post $posts, Request $request)
    {
        if($request->has('date')){
            $datetime = new Carbon($request->date.' 00:00:00');
            $posts = $posts->whereDate('created_at', $datetime);
        }
        $this->next($posts, $request);
    }
}
