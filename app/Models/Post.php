<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'author_id');
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDate($query, $date)
    {
        if(isset($date)){
            return $query->whereDate('created_at', $date);
        }
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $from
     * @param  mixed  $to
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFromTo($query, $from, $to)
    {
        if(isset($author)){
            return $query->whereBetween('created_at', [$from, $to]);
        }
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $author
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAuthor($query, $author)
    {
        if(isset($author)){
            return $query->where('author_id', $author);
        }
    }

}
