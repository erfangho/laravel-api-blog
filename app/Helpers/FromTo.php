<?php

namespace App\Helpers;

use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class FromTo extends PostFilter
{
    public $final;
    public function handle($posts, Request $request)
    {
        if($request->has('from')){
            $from = new Carbon($request->from.' 00:00:00');
            $to = new Carbon($request->to.' 00:00:00');
            $posts = $posts->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to);
        }

        $this->final = $posts->get();
    }
}
