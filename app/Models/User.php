<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizeableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticableContract, AuthorizeableContract, JWTSubject
{
	use Authenticatable, Authorizable;

	// Table name = petugas
	protected $table = 'user';
	protected $primaryKey = 'user_id';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = array('nama', 'email', 'password');
	public $timestamps = true;

	/**
	 * The attributes that should be hidden for arrays.
	 * 
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token'
	];

	/**
	 * JWT Implementation
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 * 
	 * @return mixed
	 */
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 * 
	 * @return array
	 */
	public function getJWTCustomClaims()
	{
		return [];
	}

	/* ----- Relationship ----- */
	/**
	 * Menghubungkan Model User dengan Model Keluhan.
	 */
	public function keluhan()
	{
		return $this->hasMany('App\Models\Keluhan');
	}

	/**
	 * Menghubungkan Model User dengan Model Saran.
	 */
	public function saran()
	{
		return $this->hasMany('App\Models\Saran');
	}
}
?>