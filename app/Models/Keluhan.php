<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Keluhan extends Model {
        // Table name : keluhan

        protected $table = 'keluhan';
        protected $primaryKey = 'keluhan_id';

        protected $fillable = array ('user_id', 'jenis_keluhan', 'lokasi_keluhan', 'foto_keluhan', 'isi_keluhan');

        public $timestamps = true;

        /* ----- Relationships ----- */

        /** 
         * Menghubungkan Model User dengan Model Keluhan.
         */
         public function user() {
             return $this->belongsTo('App\Models\User');
         }
    }
?>