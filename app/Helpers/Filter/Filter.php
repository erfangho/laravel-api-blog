<?php

namespace App\Helpers\Filter;

use Illuminate\Http\Request;

abstract class Filter
{
    protected $successor;

    public abstract function handle($posts, Request $request);

    public function setSuccessor(Filter $successor){
        $this->successor = $successor;
    }

    public function next($posts, Request $request){
        if($this->successor){
            $this->successor->handle($posts, $request);
        }
    }
}
