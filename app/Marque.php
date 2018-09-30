<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marque extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function modèles()
    {
        return $this->hasMany('App\Modèle');
    }
    public function types()
    {
        return $this->hasMany('App\Type');
    }
    public function moteurs()
    {
        return $this->hasMany('App\Moteur');
    }
}
