<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Tanggapan extends Model {
        // Table name : tanggapan

        protected $primaryKey = 'tanggapan_id';
        protected $table = 'tanggapan';
        protected $fillable = array ('keluhan_id', 'petugas_id', 'tanggapan', 'alasan');

        public $timestamps = true;

        /* ----- Relationships ----- */
        
         /**
          * Menghubungkan Model Petugas dengan Model Tanggapan.
          */
         public function petugas() {
             return $this->belongsTo('App\Models\Petugas');
         }

         /**
          * Menghubungkan Model Keluhan dengan Model Tanggapan.
          */
         public function keluhan() {
             return $this->hasMany('App\Models\Keluhan');
         }
    }
