<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DemandeAchat extends Model
{
    protected $guarded = [];
    public function demandeProduits()
    {
        return $this->hasMany('App\DemandeAchatProduit', 'demande_achat_id');
    }
    public function produits()
    {
        return $this->belongsToMany('App\Produit', 'demande_achat_produits', 'demande_achat_id', 'produit_id')->withPivot('coût', 'checked', 'id');
    }


    public function fournisseur()
    {
        return $this->belongsTo('App\Fournisseur');
    }
}
