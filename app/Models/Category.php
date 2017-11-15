<?php

namespace App\Models;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{
    use SoftDeletes;

    public $table = 'categories';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];


	protected $appends = ['value','label'];

	public static function boot()
	{

		parent::boot();

		static::creating(function($model)
		{
			$model->user_id = Sentinel::getUser()->id;
		});
	}


	public function getValueAttribute()
	{
		return $this->id;
	}

	public function getLabelAttribute()
	{
		return $this->name;
	}

	public function emails()
	{
		return $this->hasMany(Email::class);
	}

	public function events()
	{
		return $this->hasMany(Event::class);
	}

	public function scopeAutoemails()
	{
		return $this->emails()->where('type','=',1)->orderBy('id');
	}





}
