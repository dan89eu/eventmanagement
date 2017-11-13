<?php

namespace App\Repositories;

use App\Models\Contact_event;
use InfyOm\Generator\Common\BaseRepository;

class Contact_eventRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'event_id',
        'contact_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Contact_event::class;
    }
}
