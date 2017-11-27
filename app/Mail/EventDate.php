<?php

namespace App\Mail;

use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailer as MailerContract;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EventDate extends AbstractMessage
{
    use Queueable, SerializesModels;

	public $campaign;
	public $contacts;

	/**
	 * Create a new message instance.
	 *
	 * @param Campaign $campaign
	 * @param array $headers
	 */
    public function __construct(Campaign $campaign, array $headers = [])
    {
        $this->campaign = $campaign;
	    $this->headers = $headers;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    	if($this->campaign->content==null)
		    $this->campaign->content = "<p></p>";

        return $this->from('dan@driveprofit.com')->subject($this->campaign->subject)->markdown('emails.event');
    }

}
