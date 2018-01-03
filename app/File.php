<?php

namespace App;

use App\Models\Event;
use App\Models\EventStatus;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Eloquent\Model;

class File extends Model{

    protected $table = 'files';

    protected $guarded  = ['id'];

	public static function boot()
	{

		parent::boot();

		static::creating(function($model)
		{
			$model->user_id = Sentinel::getUser()->id;
		});
	}

	public function user(){
		return $this->belongsTo(User::class);
	}

	public function event(){
		return $this->belongsTo(Event::class);
	}

	public function statusDescription(){
		return $this->belongsTo(EventStatus::class,'status');
	}


}
