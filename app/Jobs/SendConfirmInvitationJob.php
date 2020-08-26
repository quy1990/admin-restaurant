<?php

namespace App\Jobs;

use App\Mail\SendConfirmInvitationMail;
use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendConfirmInvitationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invitation, $details;
    /**
     * Create a new job instance.
     * @param Invitation $invitation
     * @param array $details
     * @return void
     */
    public function __construct(Invitation $invitation, array $details)
    {
        $this->invitation = $invitation;
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to( $this->invitation->user->email)->send(new SendConfirmInvitationMail($this->details));
    }
}
