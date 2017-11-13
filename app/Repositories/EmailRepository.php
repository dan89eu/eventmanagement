<?php

namespace App\Repositories;

use App\Models\Email;
use InfyOm\Generator\Common\BaseRepository;

class EmailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'category_id',
        'subject',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Email::class;
    }
}
