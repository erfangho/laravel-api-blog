<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:mail {address}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending posts that created today with mail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return string
     */
    public function handle()
    {

        $posts = json_encode(Post::whereDate('created_at', Carbon::today())->get(), JSON_PRETTY_PRINT);
        Mail::raw($posts, function($message) {
            $message->to($this->argument('address'), 'User')->subject('Posts that created today');
            $message->from('erfanghorbaniergh@gmail.com','Blog project');
         });

    }
}
