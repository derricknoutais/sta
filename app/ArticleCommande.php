<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleCommande extends Model
{
    public $guarded = [];
    public function produit()
    {
        return $this->belongsTo('App\Produit', 'produit_id');
    }
}
