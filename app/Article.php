<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = [];

    public function changeEtat($etat){
        $this->update([
            'état' => $etat
        ]);
    }
    public function fiche_renseignement()
    {
        return $this->belongsTo('App\FicheRenseignement');
    }
}
