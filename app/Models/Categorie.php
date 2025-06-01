<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    //
    protected $table = 'categorie';
    
        protected $fillable = [
            'libelle'
        ];
    
        public function evenements()
        {
            return $this->belongsToMany(Evenement::class, 'etre', 'categorie_id', 'evenement_id');
        }
    
}
