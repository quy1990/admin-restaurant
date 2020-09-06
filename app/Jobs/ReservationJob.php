<?php

namespace App\Jobs;

use App\Mail\ReservationMail;
use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ReservationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reservation, $details;

    /**
     * Create a new job instance.
     * @param Reservation $reservation
     * @param array $details
     * @return void
     */
    public function __construct(Reservation $reservation, array $details)
    {
        $this->reservation = $reservation;
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emails = array_unique($this->reservation->restaurant->users->pluck('email')->toArray());
        foreach ($emails as $email) {
            Mail::to($email)->send(new ReservationMail($this->details));
        }
    }
}
