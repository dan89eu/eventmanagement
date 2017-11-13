<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateEventDateRequest;
use App\Http\Requests\UpdateEventDateRequest;
use App\Repositories\EventDateRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\EventDate;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class EventDateController extends InfyOmBaseController
{
    /** @var  EventDateRepository */
    private $eventDateRepository;

    public function __construct(EventDateRepository $eventDateRepo)
    {
        $this->eventDateRepository = $eventDateRepo;
    }

    /**
     * Display a listing of the EventDate.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $this->eventDateRepository->pushCriteria(new RequestCriteria($request));
        $eventDates = $this->eventDateRepository->all();
        return view('admin.eventDates.index')
            ->with('eventDates', $eventDates);
    }

    /**
     * Show the form for creating a new EventDate.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.eventDates.create');
    }

    /**
     * Store a newly created EventDate in storage.
     *
     * @param CreateEventDateRequest $request
     *
     * @return Response
     */
    public function store(CreateEventDateRequest $request)
    {
        $input = $request->all();

        $eventDate = $this->eventDateRepository->create($input);

        Flash::success('EventDate saved successfully.');

        return redirect(route('admin.eventDates.index'));
    }

    /**
     * Display the specified EventDate.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $eventDate = $this->eventDateRepository->findWithoutFail($id);

        if (empty($eventDate)) {
            Flash::error('EventDate not found');

            return redirect(route('eventDates.index'));
        }

        return view('admin.eventDates.show')->with('eventDate', $eventDate);
    }

    /**
     * Show the form for editing the specified EventDate.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $eventDate = $this->eventDateRepository->findWithoutFail($id);

        if (empty($eventDate)) {
            Flash::error('EventDate not found');

            return redirect(route('eventDates.index'));
        }

        return view('admin.eventDates.edit')->with('eventDate', $eventDate);
    }

    /**
     * Update the specified EventDate in storage.
     *
     * @param  int              $id
     * @param UpdateEventDateRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEventDateRequest $request)
    {
        $eventDate = $this->eventDateRepository->findWithoutFail($id);

        

        if (empty($eventDate)) {
            Flash::error('EventDate not found');

            return redirect(route('eventDates.index'));
        }

        $eventDate = $this->eventDateRepository->update($request->all(), $id);

        Flash::success('EventDate updated successfully.');

        return redirect(route('admin.eventDates.index'));
    }

    /**
     * Remove the specified EventDate from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
      public function getModalDelete($id = null)
      {
          $error = '';
          $model = '';
          $confirm_route =  route('admin.eventDates.delete',['id'=>$id]);
          return View('admin.layouts/modal_confirmation', compact('error','model', 'confirm_route'));

      }

       public function getDelete($id = null)
       {
           $sample = EventDate::destroy($id);

           // Redirect to the group management page
           return redirect(route('admin.eventDates.index'))->with('success', Lang::get('message.success.delete'));

       }

}
