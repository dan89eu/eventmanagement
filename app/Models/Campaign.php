<?php

namespace App\Models;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;


class Campaign extends Model
{
    use SoftDeletes;

    public $table = 'campaigns';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'date',
        'name',
        'user_id',
        'event_id',
	    'status',
	    'subject',
	    'content'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'user_id' => 'integer',
        'event_id' => 'integer',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

	protected $appends = ['start_date','end_date','event','text'];

	public static function boot()
	{

		parent::boot();

		static::creating(function($model)
		{
			$model->user_id = Sentinel::getUser()->id;
		});
	}

	public function getStartDateAttribute()
	{
		return $this->date;
	}

	public function getEndDateAttribute()
	{
		return $this->date;
	}

	public function getEventAttribute()
	{
		return $this->event_id;
	}

	public function getTextAttribute()
	{
		return $this->name;
	}

	public function events()
	{
		return $this->belongsTo(Event::class, 'event_id','id');
	}

}
