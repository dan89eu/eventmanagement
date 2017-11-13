<?php

namespace App\Repositories;

use App\Models\EventDate;
use InfyOm\Generator\Common\BaseRepository;

class EventDateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'event_id',
        'date',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EventDate::class;
    }
}
