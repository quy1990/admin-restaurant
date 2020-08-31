<?php

namespace App\Jobs;

use App\Mail\SendConfirmCommentMail;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendConfirmCommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $comment, $details;

    /**
     * Create a new job instance.
     * @param Comment $comment
     * @param array $details
     */
    public function __construct(Comment $comment, array $details)
    {
        $this->comment = $comment;
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $restaurant = $this->comment->commentable;
        $emails = array_unique($restaurant->users->pluck('email')->toArray());
        foreach ($emails as $email) {
            Mail::to($email)->send(new SendConfirmCommentMail($this->details));
        }
    }
}
