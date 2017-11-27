<?php

namespace App\Listeners;

use App\Models\Campaign;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use jdavidbakr\MailTracker\Events\LinkClickedEvent;

class LinkClicked
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
	 * @param LinkClickedEvent|object $event
	 * @return void
	 */
    public function handle(LinkClickedEvent $event)
    {
	    $campaign_id = $event->sent_email->getHeader('X-Campaign-ID');
	    if(!$campaign_id){
	    	return;
	    }
	    $campaign = Campaign::find($campaign_id);
	    if($campaign->status<5){
		    $campaign->status = 4;
		    $campaign->save();
	    }
    }
}
