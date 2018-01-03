<?php

namespace App\Models;

use App\File;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;


class EventStatus extends Model
{
    use SoftDeletes;

    public $table = 'event_statuses';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'value'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'value' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

	protected $appends = ['label'];

	public static function boot()
	{

		parent::boot();

		static::created(function($model)
		{
			$model->value = $model->id;
			$model->save();
		});
	}

	public function getLabelAttribute()
	{
		return $this->name;
	}

	public function events()
	{
		return $this->hasMany(Event::class);
	}

	public function files()
	{
		return $this->hasMany(File::class);
	}
}
