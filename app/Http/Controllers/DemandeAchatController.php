<?php

namespace App\Http\Controllers;

use App\DemandeAchat;
use App\Produit;
use App\DemandeAchatProduit;
use App\Article;
use DB;
use Illuminate\Http\Request;

class DemandeAchatController extends Controller
{
    public function all(){
        return DemandeAchat::all();
    }
    public function commander(Request $request){
        DB::transaction(function () use ($request) {
            foreach($request->articles as $article){
                $produit = Produit::create([
                    'variante_une' => $article['nom']
                ]);
                foreach($request->demandes as $demande){
                    DemandeAchatProduit::create([
                        'demande_achat_id' => $demande['id'],
                        'produit_id' => $produit->id
                    ]);
                    Article::find($article['id'])->update([
                        'commandé' => 1
                    ]);
                }
            }
        });
        
    }
}
