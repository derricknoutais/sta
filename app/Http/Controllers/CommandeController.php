<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commande;
class CommandeController extends Controller
{
    public function nouvelle(Request $request){
        Commande::create([
            'nom' => $request->nom
        ]);
    }
    public function all(){
        return Commande::all();
    }
    public function voir(Commande $commande){
        $commande->loadMissing(['demandes', 'demandes.fournisseur', 'commandes', 'commandes.fournisseur']);
        return view('commande.voir', compact('commande'));
    }
}
