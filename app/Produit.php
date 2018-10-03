<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    public function demandeAchat()
    {
        return $this->belongsToMany('App\DemandeAchat', 'demande_achat_produits', 'produit_id', 'demande_achat_id')->withPivot('coût');
    }

    public function bonCommande()
    {
        return $this->belongsToMany('App\BonCommande', 'bon_commande_produits', 'produit_id', 'bon_commande_id')->withPivot('coût');
    }
}
