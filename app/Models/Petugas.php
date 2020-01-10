<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Petugas extends Model {
        // Table name = petugas
        
        protected $primaryKey = 'petugas_id';

        protected $fillable = array ('email', 'password', 'role');
        
        protected $timestamps = true;

        /* ----- Relationship ----- */

        /**
         * Menghubungkan Model Petugas dengan Model Keluhan.
         */
        public function posts () {
            return $this->hasMany('App\Models\Keluhan');
        }
    }
?>