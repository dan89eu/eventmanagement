<?php

namespace App\Repositories;

use App\Models\Campaign;
use InfyOm\Generator\Common\BaseRepository;

class CampaignRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'date',
        'name',
        'user_id',
        'event_id',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Campaign::class;
    }
}
