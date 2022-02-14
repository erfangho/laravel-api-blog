<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class PostCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PostCreated  $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
        $post = json_encode($event->post, JSON_PRETTY_PRINT);
        Mail::raw($post, function($message) {
            $message->to('erfan2ghorbani@gmail.com')->subject('Posts created succesfully');
            $message->from('erfanghorbaniergh@gmail.com','Blog project');
         });
    }
}
