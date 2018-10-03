<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BonCommande extends Model
{
    protected $guarded = [];
    public function produits()
    {
        return $this->belongsToMany('App\Produit', 'bon_commande_produits', 'bon_commande_id', 'produit_id')->withPivot('coût', 'id');
    }

    public function bonCommandeProduit()
    {
        return $this->hasMany('App\BonCommandeProduit', 'bon_commande_id');
    }

    public function fournisseur()
    {
        return $this->belongsTo('App\Fournisseur');
    }
    public function demandeAchat(){
        return $this->belongsTo('App\DemandeAchat');
    }
}
