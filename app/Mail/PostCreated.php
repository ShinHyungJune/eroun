<?php

namespace App\Mail;

use App\Models\Blog;
use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostCreated extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $receiver;
    protected $blog;
    protected $post;

    public function __construct(User $receiver, Blog $blog, Post $post)
    {
        $this->receiver = $receiver;
        $this->blog = $blog;
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.posts.created')
            ->subject("[".config("app.name")."] ".$this->post->title." post is created.")
            ->with(["receiver" => $this->receiver, "blog" => $this->blog, "post" => $this->post]);
    }
}
