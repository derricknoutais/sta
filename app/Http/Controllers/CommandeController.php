<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commande;
use App\Article;
use App\Produit;
use App\ProduitCommande;
use App\ArticleCommande;
use DB;
use App\Playground;

class CommandeController extends Controller
{
    public function store(Request $request){
        $commande = Commande::create([
            'nom' => $request->nom
        ]);
        $playground = Playground::create([
            'commande_id' => $commande->id,
            'nom' => 'Playground ' . $request->nom
        ]);
        
        $commande->update([
            'playground_id' => $playground->id
        ]);


        return redirect('/commande/répertoire');
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
        $articles = Article::where('commandé', 0)->get();
        return view('commande.voir-produits', compact('commande', 'produits', 'articles'));
    }
    public function ajouteProduits (Commande $commande, Request $request) {
        ProduitCommande::create([
            'produit_id' => $request->id,
            'commande_id' =>$commande->id
        ]);
    }
    public function ajouteArticles(Commande $commande, Request $request) {
        ArticleCommande::create([
            'article_id' => $request->id,
            'commande_id' =>$commande->id
        ]);
    }
}
