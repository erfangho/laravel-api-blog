<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author_id' => $this->author_id,
            'body' => $this->body,
            'image' => asset($this->image),
            'thumbnail' => asset($this->thumbnail),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
