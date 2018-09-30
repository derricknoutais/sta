<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modèle extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function marque()
    {
        return $this->belongsTo('App\Marque');
    }

    public function types()
    {
        return $this->belongsToMany('App\Type', 'modèle_type', 'modèle_id', 'type_id');
    }
}
