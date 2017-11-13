<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Repositories\CampaignRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\Campaign;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CampaignController extends InfyOmBaseController
{
    /** @var  CampaignRepository */
    private $campaignRepository;

    public function __construct(CampaignRepository $campaignRepo)
    {
        $this->campaignRepository = $campaignRepo;
    }

    /**
     * Display a listing of the Campaign.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $this->campaignRepository->pushCriteria(new RequestCriteria($request));
        $campaigns = $this->campaignRepository->all();
        return view('admin.campaigns.index')
            ->with('campaigns', $campaigns);
    }

    /**
     * Show the form for creating a new Campaign.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.campaigns.create');
    }

    /**
     * Store a newly created Campaign in storage.
     *
     * @param CreateCampaignRequest $request
     *
     * @return Response
     */
    public function store(CreateCampaignRequest $request)
    {
        $input = $request->all();

        $campaign = $this->campaignRepository->create($input);

        Flash::success('Campaign saved successfully.');

        return redirect(route('admin.campaigns.index'));
    }

    /**
     * Display the specified Campaign.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $campaign = $this->campaignRepository->findWithoutFail($id);

        if (empty($campaign)) {
            Flash::error('Campaign not found');

            return redirect(route('campaigns.index'));
        }

        return view('admin.campaigns.show')->with('campaign', $campaign);
    }

    /**
     * Show the form for editing the specified Campaign.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $campaign = $this->campaignRepository->findWithoutFail($id);

        if (empty($campaign)) {
            Flash::error('Campaign not found');

            return redirect(route('campaigns.index'));
        }

        return view('admin.campaigns.edit')->with('campaign', $campaign);
    }

    /**
     * Update the specified Campaign in storage.
     *
     * @param  int              $id
     * @param UpdateCampaignRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCampaignRequest $request)
    {
        $campaign = $this->campaignRepository->findWithoutFail($id);

        

        if (empty($campaign)) {
            Flash::error('Campaign not found');

            return redirect(route('campaigns.index'));
        }

        $campaign = $this->campaignRepository->update($request->all(), $id);

        Flash::success('Campaign updated successfully.');

        return redirect(route('admin.campaigns.index'));
    }

    /**
     * Remove the specified Campaign from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
      public function getModalDelete($id = null)
      {
          $error = '';
          $model = '';
          $confirm_route =  route('admin.campaigns.delete',['id'=>$id]);
          return View('admin.layouts/modal_confirmation', compact('error','model', 'confirm_route'));

      }

       public function getDelete($id = null)
       {
           $sample = Campaign::destroy($id);

           // Redirect to the group management page
           return redirect(route('admin.campaigns.index'))->with('success', Lang::get('message.success.delete'));

       }

}
