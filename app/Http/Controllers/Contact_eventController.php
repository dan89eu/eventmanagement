<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateContact_eventRequest;
use App\Http\Requests\UpdateContact_eventRequest;
use App\Repositories\Contact_eventRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\ContactEvent;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class Contact_eventController extends InfyOmBaseController
{
    /** @var  Contact_eventRepository */
    private $contactEventRepository;

    public function __construct(Contact_eventRepository $contactEventRepo)
    {
        $this->contactEventRepository = $contactEventRepo;
    }

    /**
     * Display a listing of the Contact_event.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $this->contactEventRepository->pushCriteria(new RequestCriteria($request));
        $contactEvents = $this->contactEventRepository->all();
        return view('admin.contactEvents.index')
            ->with('contactEvents', $contactEvents);
    }

    /**
     * Show the form for creating a new Contact_event.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.contactEvents.create');
    }

    /**
     * Store a newly created Contact_event in storage.
     *
     * @param CreateContact_eventRequest $request
     *
     * @return Response
     */
    public function store(CreateContact_eventRequest $request)
    {
        $input = $request->all();

        $contactEvent = $this->contactEventRepository->create($input);

        Flash::success('Contact_event saved successfully.');

        return redirect(route('admin.contactEvents.index'));
    }

    /**
     * Display the specified Contact_event.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $contactEvent = $this->contactEventRepository->findWithoutFail($id);

        if (empty($contactEvent)) {
            Flash::error('Contact_event not found');

            return redirect(route('contactEvents.index'));
        }

        return view('admin.contactEvents.show')->with('contactEvent', $contactEvent);
    }

    /**
     * Show the form for editing the specified Contact_event.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $contactEvent = $this->contactEventRepository->findWithoutFail($id);

        if (empty($contactEvent)) {
            Flash::error('Contact_event not found');

            return redirect(route('contactEvents.index'));
        }

        return view('admin.contactEvents.edit')->with('contactEvent', $contactEvent);
    }

    /**
     * Update the specified Contact_event in storage.
     *
     * @param  int              $id
     * @param UpdateContact_eventRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateContact_eventRequest $request)
    {
        $contactEvent = $this->contactEventRepository->findWithoutFail($id);

        

        if (empty($contactEvent)) {
            Flash::error('Contact_event not found');

            return redirect(route('contactEvents.index'));
        }

        $contactEvent = $this->contactEventRepository->update($request->all(), $id);

        Flash::success('Contact_event updated successfully.');

        return redirect(route('admin.contactEvents.index'));
    }

    /**
     * Remove the specified Contact_event from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
      public function getModalDelete($id = null)
      {
          $error = '';
          $model = '';
          $confirm_route =  route('admin.contactEvents.delete',['id'=>$id]);
          return View('admin.layouts/modal_confirmation', compact('error','model', 'confirm_route'));

      }

       public function getDelete($id = null)
       {
           $sample = ContactEvent::destroy($id);

           // Redirect to the group management page
           return redirect(route('admin.contactEvents.index'))->with('success', Lang::get('message.success.delete'));

       }

}
