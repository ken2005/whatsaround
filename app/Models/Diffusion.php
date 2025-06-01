<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diffusion extends Model
{
    //
    protected $table = 'diffusion';
    
        protected $fillable = [
            'libelle'
        ];
    
        public function evenements()
        {
            return $this->hasMany(Evenement::class);
        }
    
}
