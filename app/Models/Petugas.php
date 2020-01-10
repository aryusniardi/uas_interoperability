<?php
    namespace App\Models;

    use Illuminate\Auth\Authenticatable;
    use Laravel\Lumen\Auth\Authorizable;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Contracts\Auth\Authenticatable as AuthenticableContract;
    use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizeableContract;
    use Tymon\JWTAuth\Contracts\JWTSubject;

    class Petugas extends Model implements AuthenticableContract, AuthorizeableContract, JWTSubject {
        use Authenticatable, Authorizable;

        // Table name = petugas
        protected $primaryKey = 'petugas_id';
        protected $fillable = array ('email', 'password', 'role');
        public $timestamps = true;

        /**
         * The attributes exclude from the model's json form.
         * 
         * @var array
         */
        protected $hidden = [
            'password'
        ];
        
        /**
         * JWT Implementation
         * Get the identifier that will be stored in the subject claim of the JWT.
         * 
         * @return mixed
         */
        public function getJWTIdentifier() {
            return $this->getKey();
        }

        /**
         * Return a key value array, containing any custom claims to be added to the JWT
         * 
         * @return array
         */
        public function getJWTCustomClaims() {
            return [];
        }

        /* ----- Relationship ----- */
        /**
         * Menghubungkan Model Petugas dengan Model Keluhan.
         */
        public function posts () {
            return $this->hasMany('App\Models\Keluhan');
        }
    }
?>