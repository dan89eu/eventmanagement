<?php

namespace App\Models;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;


class Event extends Model
{
    use SoftDeletes;

    public $table = 'events';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'start_date',
        'end_date',
        'name',
        'details',
	    'status',
	    'category',
	    'category_id',
	    'campaign_start_date',
	    'campaign_end_date',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'details' => 'string',
        'status' => 'integer',
        'category' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'start_date' => 'date',
        'end_date' => 'date',
        'name' => 'required'
    ];


	protected $appends = ['type','label','value'];

	public static function boot()
	{

		parent::boot();

		static::creating(function($model)
		{
			$model->user_id = Sentinel::getUser()->id;
		});
	}

	public function contacts()
	{
		return $this->belongsToMany(Contact::class)->using(ContactEvent::class);
	}

	public function campaigns()
	{
		return $this->hasMany(Campaign::class);
	}


	public function getTypeAttribute()
	{
		return $this->category_id;
	}

	public function getLabelAttribute()
	{
		return $this->name;
	}

	public function getValueAttribute()
	{
		return $this->id;
	}



}
