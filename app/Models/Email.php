<?php

namespace App\Models;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;


class Email extends Model
{
    use SoftDeletes;

    public $table = 'emails';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'category_id',
        'user_id',
        'subject',
        'content',
        'type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'category_id' => 'integer',
        'user_id' => 'integer',
        'subject' => 'string',
        'content' => 'string',
        'type' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
	    'name' => 'required',
	    'category_id' => 'required',
	    'subject' => 'required',
	    'type' => 'required'
    ];

	public static function boot()
	{

		parent::boot();

		static::creating(function($model)
		{
			$model->user_id = Sentinel::getUser()->id;
		});
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function category()
	{
		return $this->belongsTo(Category::class);
	}


	/**
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @param $category
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeOfCategory($query, $category)
	{
		return $query->where('category_id', $category);
	}

	/**
	 * @param \Illuminate\Database\Eloquent\Builder $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeAutomatic($query)
	{
		return $query->where('type', '=', 1)->orderBy('id');
	}

}
