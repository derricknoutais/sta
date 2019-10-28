<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $guarded = [];

    public function playground()
    {
        return $this->hasOne('App\Playground');
    }

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

    public function articles()
    {
        return $this->belongsToMany('App\Article', 'article_commandes', 'commande_id', 'article_id');
    }
}
