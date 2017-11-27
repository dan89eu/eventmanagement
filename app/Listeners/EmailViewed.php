<?php

namespace App\Listeners;

use App\Models\Campaign;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use jdavidbakr\MailTracker\Events\ViewEmailEvent;

class EmailViewed
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

	/**
	 * Handle the event.
	 *
	 * @param ViewEmailEvent|object $event
	 * @return void
	 */
    public function handle(ViewEmailEvent $event)
    {
	    $campaign_id = $event->sent_email->getHeader('X-Campaign-ID');
	    if(!$campaign_id){
		    return;
	    }
	    $campaign = Campaign::find($campaign_id);
	    if($campaign->status<4){
			$campaign->status = 3;
			$campaign->save();
	    }
    }
}
