<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $guarded = [];
    
    public function demandes()
    {
        return $this->hasMany('App\DemandeAchat', 'commande_id');
    }
    public function commandes()
    {
        return $this->hasMany('App\BonCommande', 'commande_id');
    }
    public function produits()
    {
        return $this->belongsToMany('App\Produit', 'produit_commandes', 'commande_id', 'produit_id');
    }
}
