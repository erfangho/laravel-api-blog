<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Support\Facades\Mail;

class PostCreatedNotification
{
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
            $message->to(config('const.admin_mail'))->subject('Posts created succesfully');
        });
    }
}
