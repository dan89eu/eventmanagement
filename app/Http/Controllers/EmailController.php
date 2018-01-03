<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateEmailRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Repositories\EmailRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\Email;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class EmailController extends InfyOmBaseController
{
    /** @var  EmailRepository */
    private $emailRepository;

    public function __construct(EmailRepository $emailRepo)
    {
        $this->emailRepository = $emailRepo;
    }

    /**
     * Display a listing of the Email.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $this->emailRepository->pushCriteria(new RequestCriteria($request));

	    if(Sentinel::inRole('admin')){
		    $emails = $this->emailRepository->all();
	    }
	    else{
		    $emails = $this->emailRepository->findByField('user_id',$this->getUserId());
	    }

        return view('admin.emails.index')
            ->with('emails', $emails);
    }

    public function test(){
    	$client = new Client();
	    $response = $client->post('https://api.sparkpost.com/api/v1/transmissions', [
		    'headers' => [
			    'Authorization' => $this->key,
		    ],
		    'json' => array_merge([
			    'recipients' => ['dan@driveprofit.com'],
			    'content' => [
				    'email_rfc822' => 'salut',
			    ],
		    ], $this->options),
	    ]);
	    var_dump($response);
    }

    /**
     * Show the form for creating a new Email.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.emails.create');
    }

    /**
     * Store a newly created Email in storage.
     *
     * @param CreateEmailRequest $request
     *
     * @return Response
     */
    public function store(CreateEmailRequest $request)
    {
        $input = $request->all();

        $email = $this->emailRepository->create($input);

        Flash::success('Email saved successfully.');

        return redirect(route('admin.emails.index'));
    }

    /**
     * Display the specified Email.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $email = $this->emailRepository->findWithoutFail($id);

	   /* if($email->user_id != $this->getUserId()){
		    unset($email);
	    }*/

        if (empty($email)) {
            Flash::error('Email not found');

            return redirect(route('admin.emails.index'));
        }

        return view('admin.emails.show')->with('email', $email);
    }

    /**
     * Show the form for editing the specified Email.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $email = $this->emailRepository->findWithoutFail($id);

	    /*if($email->user_id != $this->getUserId()){
		    unset($email);
	    }*/
        if (empty($email)) {
            Flash::error('Email not found');

            return redirect(route('emails.index'));
        }

        return view('admin.emails.edit')->with('email', $email);
    }

    /**
     * Update the specified Email in storage.
     *
     * @param  int              $id
     * @param UpdateEmailRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEmailRequest $request)
    {
        $email = $this->emailRepository->findWithoutFail($id);

	    /*if($email->user_id != $this->getUserId()){
		    unset($email);
	    }*/
        
                        if($request->has('type')){
	                    $request->merge(['type' => 1]);
	                    }
                        else{
                        $request->merge(['type' => 0]);
                         }

        if (empty($email)) {
            Flash::error('Email not found');

            return redirect(route('emails.index'));
        }

        $email = $this->emailRepository->update($request->all(), $id);

        Flash::success('Email updated successfully.');

        return redirect(route('admin.emails.index'));
    }

    /**
     * Remove the specified Email from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
      public function getModalDelete($id = null)
      {
          $error = '';
          $model = '';
          $confirm_route =  route('admin.emails.delete',['id'=>$id]);
          return View('admin.layouts/modal_confirmation', compact('error','model', 'confirm_route'));

      }

       public function getDelete($id = null)
       {
           $sample = Email::destroy($id);

           // Redirect to the group management page
           return redirect(route('admin.emails.index'))->with('success', Lang::get('message.success.delete'));

       }

}
