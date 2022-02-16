<?php

namespace App\Helpers;

use Illuminate\Http\Request;

abstract class PostFilter
{
    protected $successor;

    public abstract function handle(Request $request);

    public function setSuccessor(PostFilter $successor){
        $this->successor = $successor;
    }

    public function next(Request $request){
        if($this->successor){
            $this->successor->handle($request);
        }
    }
}
