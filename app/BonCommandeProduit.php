<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BonCommandeProduit extends Model
{
    protected $guarded = [];

    public function bonCommande()
    {
        return $this->belongsTo('App\BonCommande', 'bon_commande_id');
    }
}
