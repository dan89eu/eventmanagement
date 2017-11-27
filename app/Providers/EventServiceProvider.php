<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        'jdavidbakr\MailTracker\Events\ViewEmailEvent' => [
	        'App\Listeners\EmailViewed',
        ],
        'jdavidbakr\MailTracker\Events\LinkClickedEvent' => [
	        'App\Listeners\LinkClicked',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
