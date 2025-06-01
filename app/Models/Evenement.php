<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    protected $table = 'evenement';

    protected $fillable = [
        'nom',
        'description',
        'image',
        'date',
        'heure',
        //'lieu',
        'user_id',
        'num_rue',
        'allee',
        'ville',
        'code_postal',
        'pays',
        'diffusion_id',
        'annonciateur'
    ];

    protected $casts = [
        'date' => 'date',
        'annonciateur' => 'boolean'
    ];

    public function user()
        {
            return $this->belongsTo(User::class);
        }
    
    public function inscriptions()
    {
            return $this->belongsToMany(User::class, 's_inscrire', 'evenement_id', 'user_id');
        }

    public function enregistrements()
    {
            return $this->belongsToMany(User::class, 'enregistrer', 'evenement_id', 'user_id');
        }
    public function categories()
    {
            return $this->belongsToMany(Categorie::class, 'etre', 'evenement_id', 'categorie_id');
        }
    public function diffusion()
    {
            return $this->belongsTo(Diffusion::class);
        }
    
}
