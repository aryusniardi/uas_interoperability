<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Saran extends Model {
        // Table name : saran

        protected $table = 'saran';
        protected $primaryKey = 'saran_id';

        protected $fillable = array ('user_id', 'jenis_saran', 'lokasi_saran', 'isi_saran');

        public $timestamps = true;

        
        /* ----- Relationships ----- */
        
        /* 
         * Menghubungkan Model User dengan Model Saran.
         */
         public function user() {
             return $this->belongsTo('App\Models\User');
         }
    }
