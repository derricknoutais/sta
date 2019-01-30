<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commande;
use App\Article;
use App\Produit;
use App\ProduitCommande;
use App\ArticleCommande;
use DB;
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
    public function commander(Request $request){

        DB::transaction(function () use ($request) {
            foreach($request->articles as $article){
                foreach($request->commandes as $commande){
                    ArticleCommande::create([
                        'commande_id' => $commande['id'],
                        'article_id' => $article['id']
                    ]);
                    Article::find($article['id'])->update([
                        'commandé' => 1
                    ]);
                }
            }
        });
        
    }
    public function voirProduits (Commande $commande) {
        $commande->loadMissing('produits');
        $produits = Produit::all();
        return view('commande.voir-produits', compact('commande', 'produits'));
    }
    public function ajouteProduits (Commande $commande, Request $request) {
        ProduitCommande::create([
            'produit_id' => $request->id,
            'commande_id' =>$commande->id
        ]);
    }
}
