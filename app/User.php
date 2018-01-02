<?php namespace App;
use App\Models\Company;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentTaggable\Taggable;
use Lab404\Impersonate\Models\Impersonate;


class User extends EloquentUser {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */


	use Impersonate;

	protected $table = 'users';

	protected $attributes = [
		'company_id' => 0
	];

	/**
	 * The attributes to be fillable from the model.
	 *
	 * A dirty hack to allow fields to be fillable by calling empty fillable array
	 *
	 * @var array
	 */
    use Taggable;

	protected $fillable = [];
	protected $guarded = ['id'];
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	* To allow soft deletes
	*/
	use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $appends = ['full_name'];
    public function getFullNameAttribute()
    {
        return str_limit($this->first_name . ' ' . $this->last_name, 30);
    }

	public function companyCreated(){
		return $this->hasOne(Company::class);
	}

	public function company(){
		return $this->belongsTo(Company::class);
	}
}
