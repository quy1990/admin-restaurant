<?php

namespace App\Jobs;

use App\Mail\SendConfirmMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class sendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $people, $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($people, $details)
    {
        $this->people = $people;
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to( $this->people->email)->send(new SendConfirmMail($this->details));
    }
}
