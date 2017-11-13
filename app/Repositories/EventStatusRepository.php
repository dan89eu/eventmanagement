<?php

namespace App\Repositories;

use App\Models\EventStatus;
use InfyOm\Generator\Common\BaseRepository;

class EventStatusRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EventStatus::class;
    }
}
