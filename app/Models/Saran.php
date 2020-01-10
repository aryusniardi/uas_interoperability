<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Saran extends Model {
        // Table name : saran

        protected $primaryKey = 'saran_id';

        protected $fillable = array ('user_id', 'jenis_saran', 'lokasi_sarab', 'isi_saran');

        protected $timestamps = true;

        
        /* ----- Relationships ----- */
        
        /* 
         * Menghubungkan Model User dengan Model Saran.
         */
         public function user() {
             return $this->belongsTo('App\Models\User');
         }
    }
