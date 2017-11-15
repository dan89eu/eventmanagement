<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Campaign;
use App\Models\Category;
use App\Models\EventStatus;
use App\Repositories\EventRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use App\Models\Event;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Dhtmlx\Connector\SchedulerConnector;

class EventController extends InfyOmBaseController
{
    /** @var  EventRepository */
    private $eventRepository;

    public function __construct(EventRepository $eventRepo)
    {
        $this->eventRepository = $eventRepo;
    }

    /**
     * Display a listing of the Event.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $this->eventRepository->pushCriteria(new RequestCriteria($request));
        $events = $this->eventRepository->all();
        return view('admin.events.index')
            ->with('events', $events);
    }

	public function data()
	{

		$eventsArr = Event::all();
		$campaignArr = Campaign::all();
		$categoryArr = Category::all();
		$eventStatusArr = EventStatus::all(['id','value','name']);

		foreach($eventsArr as $event){
			$evt = clone($event);
			$evt->event = $evt->id;
			$evt->id = $evt->id+1000;
			$campaignArr[] = $evt;
		}

		return response()->json(['data'=>$campaignArr,'collections'=>['eventType'=>$categoryArr,'eventStatus'=>$eventStatusArr,'event'=>$eventsArr]]);
	}

	public function editData(Request $request)
	{


		return response()->json($request->all());
	}

    /**
     * Show the form for creating a new Event.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created Event in storage.
     *
     * @param CreateEventRequest $request
     *
     * @return Response
     */
    public function store(CreateEventRequest $request)
    {
        $input = $request->all();

        $event = $this->eventRepository->create($input);

	    $this->createCampaigns($event);

	    $this->syncContacts($event);

        Flash::success('Event saved successfully.');

        return redirect(route('admin.events.index'));
    }

    private function syncContacts(Event $event)
    {
	    $contacts  = (array) Input::get('contacts'); // related ids
	    $pivotData = array_fill(0, count($contacts), ['user_id' => Sentinel::getUser()->id]);
	    $syncContacts  = array_combine($contacts, $pivotData);
	    $event->contacts()->sync($syncContacts);
    }

	/**
	 * @param Event $event
	 */
	private function createCampaigns($event)
    {

    	$emails = $event->category->autoemails()->get();

    	//dd($emails);

    	$no_emails = count($emails);

	    $start_date = new Carbon($event->campaign_start_date);
	    $end_date = new Carbon($event->campaign_end_date);

	    $diff = $start_date->diffInDays($end_date);
	    $period = $diff/($no_emails-1);

	    foreach ($emails as $email)
	    {
			$campaign = new Campaign();
		    $campaign->name = $email->name;
		    $campaign->subject = $email->subject;
		    $campaign->content = $email->content;
		    $campaign->event_id = $event->id;
		    $campaign->status = 1;
		    $campaign->date = $start_date->toDateString();
		    $start_date->addDay($period);
		    $campaign->save();
	    }

    }

    /**
     * Display the specified Event.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $event = $this->eventRepository->findWithoutFail($id);

        if (empty($event)) {
            Flash::error('Event not found');

            return redirect(route('events.index'));
        }

        return view('admin.events.show')->with('event', $event);
    }

    /**
     * Show the form for editing the specified Event.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $event = $this->eventRepository->findWithoutFail($id);

        if (empty($event)) {
            Flash::error('Event not found');

            return redirect(route('events.index'));
        }

        return view('admin.events.edit')->with('event', $event);
    }

    /**
     * Update the specified Event in storage.
     *
     * @param  int              $id
     * @param UpdateEventRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEventRequest $request)
    {
        $event = $this->eventRepository->findWithoutFail($id);

        if (empty($event)) {
            Flash::error('Event not found');

            return redirect(route('events.index'));
        }

        $event = $this->eventRepository->update($request->all(), $id);

	    $this->syncContacts($event);

        Flash::success('Event updated successfully.');

        return redirect(route('admin.events.index'));
    }

    /**
     * Remove the specified Event from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
      public function getModalDelete($id = null)
      {
          $error = '';
          $model = '';
          $confirm_route =  route('admin.events.delete',['id'=>$id]);
          return View('admin.layouts/modal_confirmation', compact('error','model', 'confirm_route'));

      }

       public function getDelete($id = null)
       {
           $sample = Event::destroy($id);

           // Redirect to the group management page
           return redirect(route('admin.events.index'))->with('success', Lang::get('message.success.delete'));

       }

}
