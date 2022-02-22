<?php

namespace App\Helpers\Filter;

use Carbon\Carbon;
use Illuminate\Http\Request;

class FromTo extends Filter
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
        $this->next($posts, $request);
    }
}
