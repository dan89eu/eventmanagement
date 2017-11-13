<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateEventStatusRequest;
use App\Http\Requests\UpdateEventStatusRequest;
use App\Repositories\EventStatusRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\EventStatus;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class EventStatusController extends InfyOmBaseController
{
    /** @var  EventStatusRepository */
    private $eventStatusRepository;

    public function __construct(EventStatusRepository $eventStatusRepo)
    {
        $this->eventStatusRepository = $eventStatusRepo;
    }

    /**
     * Display a listing of the EventStatus.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $this->eventStatusRepository->pushCriteria(new RequestCriteria($request));
        $eventStatuses = $this->eventStatusRepository->all();
        return view('admin.eventStatuses.index')
            ->with('eventStatuses', $eventStatuses);
    }

    /**
     * Show the form for creating a new EventStatus.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.eventStatuses.create');
    }

    /**
     * Store a newly created EventStatus in storage.
     *
     * @param CreateEventStatusRequest $request
     *
     * @return Response
     */
    public function store(CreateEventStatusRequest $request)
    {
        $input = $request->all();

        $eventStatus = $this->eventStatusRepository->create($input);

        Flash::success('EventStatus saved successfully.');

        return redirect(route('admin.eventStatuses.index'));
    }

    /**
     * Display the specified EventStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $eventStatus = $this->eventStatusRepository->findWithoutFail($id);

        if (empty($eventStatus)) {
            Flash::error('EventStatus not found');

            return redirect(route('eventStatuses.index'));
        }

        return view('admin.eventStatuses.show')->with('eventStatus', $eventStatus);
    }

    /**
     * Show the form for editing the specified EventStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $eventStatus = $this->eventStatusRepository->findWithoutFail($id);

        if (empty($eventStatus)) {
            Flash::error('EventStatus not found');

            return redirect(route('eventStatuses.index'));
        }

        return view('admin.eventStatuses.edit')->with('eventStatus', $eventStatus);
    }

    /**
     * Update the specified EventStatus in storage.
     *
     * @param  int              $id
     * @param UpdateEventStatusRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEventStatusRequest $request)
    {
        $eventStatus = $this->eventStatusRepository->findWithoutFail($id);

        

        if (empty($eventStatus)) {
            Flash::error('EventStatus not found');

            return redirect(route('eventStatuses.index'));
        }

        $eventStatus = $this->eventStatusRepository->update($request->all(), $id);

        Flash::success('EventStatus updated successfully.');

        return redirect(route('admin.eventStatuses.index'));
    }

    /**
     * Remove the specified EventStatus from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
      public function getModalDelete($id = null)
      {
          $error = '';
          $model = '';
          $confirm_route =  route('admin.eventStatuses.delete',['id'=>$id]);
          return View('admin.layouts/modal_confirmation', compact('error','model', 'confirm_route'));

      }

       public function getDelete($id = null)
       {
           $sample = EventStatus::destroy($id);

           // Redirect to the group management page
           return redirect(route('admin.eventStatuses.index'))->with('success', Lang::get('message.success.delete'));

       }

}
