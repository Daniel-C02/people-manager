<?php

namespace App\Jobs;

use App\Mail\WelcomeEmail;
use App\Models\Person;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The person instance.
     *
     * @var Person
     */
    protected $person;

    /**
     * Create a new job instance.
     */
    public function __construct(Person $person)
    {
        $this->person = $person;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->person->email)->send(new WelcomeEmail($this->person));
    }
}
