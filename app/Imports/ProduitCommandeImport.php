<?php

namespace App\Imports;

use App\ProduitCommande;
use App\Produit;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProduitCommandeImport implements ToCollection
{
    private $commande;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    function __construct($commande){
        $this->commande = $commande;
    }
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $produit = Produit::where('sku', $row[4])->first();
            if($produit){
                ProduitCommande::create([
                    'produit_id' => $produit->id,
                    'commande_id' => $this->commande
                ]);
            }
        }
    }
}
