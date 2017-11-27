<?php

namespace App\Console\Commands;

use App\Mail\EventDate;
use App\Models\Campaign;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all past emails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $campaigns = Campaign::where('sent',0)->where('date','<=',date('Y-m-d'))->get();


        foreach ($campaigns as $campaign){


	        /*Mail::queue('emails.event',['campaign'=>$campaign],function($message) use($campaign){
	        	$message->from('dan@driveprofit.com');
	        	$message->to('dan@driveprofit.com');
	        	$message->subject($campaign->subject);
		        $message->getHeaders()->addTextHeader('X-Header-Test','32');

	        });*/

        	$contacts = $campaign->events->contacts;
        	foreach ($contacts as $contact){
		        Mail::to($contact->email)->send(new EventDate($campaign, ['X-Campaign-ID'=>$campaign->id]));
	        }
	        $campaign->sent = 1;
	        $campaign->status = 2;
	        $campaign->save();
        }
    }
}
