<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moteur extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function marque()
    {
        return $this->belongsTo('App\Marque');
    }

    public function type()
    {
        return $this->belongsToMany('App\Type', 'type_moteur', 'moteur_id', 'type_id');
    }
}
