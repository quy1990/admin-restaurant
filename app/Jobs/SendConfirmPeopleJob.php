<?php

namespace App\Jobs;

use App\Mail\SendConfirmPeopleMail;
use App\Models\People;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendConfirmPeopleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $people, $details;

    /**
     * Create a new job instance.
     * @param People $people
     * @param array $details
     * @return void
     */
    public function __construct(People $people, array $details)
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
        Mail::to($this->people->email)->send(new SendConfirmPeopleMail($this->details));
    }
}
