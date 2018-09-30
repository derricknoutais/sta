<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function marque()
    {
        return $this->belongsTo('App\Marque');
    }

    public function moteurs()
    {
        return $this->belongsToMany('App\Moteur', 'type_moteur', 'type_id', 'moteur_id');
    }

    public function modèles()
    {
        return $this->belongsToMany('App\Modèle', 'modèle_type', 'type_id', 'modèle_id');
    }
}
