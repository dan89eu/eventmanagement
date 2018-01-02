<?php

	namespace App\Models;

	use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
	use Illuminate\Database\Eloquent\Relations\Pivot;


	class CompanyUser extends Pivot
	{
		public $table = 'company_user';

		public static function boot()
		{
			parent::boot();

			static::creating(function($model)
			{
				$model->fk_user_id = Sentinel::getUser()->id;
			});
		}
	}