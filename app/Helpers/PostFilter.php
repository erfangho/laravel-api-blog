<?php

namespace App\Helpers;

use App\Models\Post;
use Illuminate\Http\Request;

abstract class PostFilter
{
    protected $successor;

    public abstract function handle($posts, Request $request);

    public function setSuccessor(PostFilter $successor){
        $this->successor = $successor;
    }

    public function next($posts, Request $request){
        if($this->successor){
            $this->successor->handle($posts, $request);
        }
    }
}
