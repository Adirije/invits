<?php

namespace App\Jobs;

use App\Mail\Invite;
use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendInvitationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emails;
    
    protected $eventId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emails, $eventId)
    {
        $this->emails = $emails;
        $this->eventId = $eventId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->emails as $email){
            $invite = new Invitation;

            $invite->event_id = $this->eventId;
            $invite->email = $email;

            $invite->save();

            Mail::to($email)->send(new Invite($invite));
        }
    }
}
