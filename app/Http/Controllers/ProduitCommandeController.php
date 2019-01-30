<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ProduitCommandeImport;
use App\ProduitCommande;
use Excel;

class ProduitCommandeController extends Controller
{
    public function upload(Request $request){
        // return $request->all();
        Excel::import(new ProduitCommandeImport($request->commande), request()->file('file'));
        // return (new ProduitCommandeImport);
    }
    public function all($commande){
        return ProduitCommande::where('commande_id', $commande)->with('produit')->get();
    }
    public function destroy(ProduitCommande $produitcommande){
        $produitcommande->delete();
    }

}
