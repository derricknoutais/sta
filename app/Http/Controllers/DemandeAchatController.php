<?php

namespace App\Http\Controllers;

use App\DemandeAchat;
use App\Produit;
use App\DemandeAchatProduit;
use App\Article;
use App\Commande;
use DB;
use Illuminate\Http\Request;

class DemandeAchatController extends Controller
{
    public function all(){
        return DemandeAchat::with('fournisseur')->get();
    }
    public function creer(Request $request){
        
        DemandeAchat::create([
            'numéro' => $request->numero,
            'fournisseur_id' => $request->fournisseur,
            'commande_id' => $request->commande
        ]);
    }
    public function créerDemandesParFournisseur(Commande $commande){
        $commande->loadMissing('produits');
        DB::transaction(function () use ($commande){
            foreach ($commande->produits as $produit) {
                $demandeExiste = DemandeAchat::where(['commande_id' => $commande->id, 'fournisseur_id' => $produit->fournisseur_id])->first();

                if($demandeExiste){
                    DemandeAchatProduit::create([
                        'demande_achat_id' => $demandeExiste->id,
                        'produit_id' => $produit->id,
                    ]);
                } else {
                    // Crée la Demande
                    $demande = DemandeAchat::create([
                        'fournisseur_id' => $produit->fournisseur_id,
                        'commande_id' => $commande->id
                    ]);
                    // Ajoute le numéro
                    $numéro = '';
                    if($demande->id < 10) { $numéro = 'DA00' . $demande->id; } elseif($demande->id < 100) { $numéro = 'DA0' . $demande->id; } else { $numéro = 'DA' . $demande->id; }
                    $demande->update([
                        'numéro' => $numéro
                    ]);
                    // Ajoute le produit
                    DemandeAchatProduit::create([
                        'demande_achat_id' => $demande->id,
                        'produit_id' => $produit->id,
                    ]);
                }
            }
        });
        
    }
    public function voir(DemandeAchat $demande){
        $demande->loadMissing(['produits', 'fournisseur']);
        return view('demande-achat.voir', compact('demande'));
    }

    public function enregistrerCoût(Request $request){
        foreach($request->all() as $req){
            DemandeAchatProduit::find($req['index'])->update([
                'coût' => $req['coût'],
                'quantité' => $req['quantité'],
                'total' => $req['total']
            ]);
        }
    }
    public function ajouterQuantité(Request $request){
        foreach($request->all() as $req){
            $demande = DemandeAchatProduit::find($req['id']);
            if(isset($req['quantité']) && isset($req['coût'])){
                $demande->update([
                    'coût' => $req['coût'],
                    'quantité' => $req['quantité'],
                ]);
            } elseif(isset($req['quantité'])){
                $demande->update([
                    'quantité' => $req['quantité'],
                ]);
            } elseif(isset($req['coût'])){
                $demande->update([
                    'coût' => $req['coût'],
                ]);
            }
            $demande = DemandeAchatProduit::find($req['id']);
            if(isset($demande->quantité) && isset($demande->coût)){
                $demande->update([
                    'total' => $demande->quantité * $demande->coût
                ]);
            }
            
        }
        // $demandes = DemandeAchatProduit::where('demande_achat_id', $demande->demande_achat_id)->get();
        // if($demandes){
        //     $empty = false; 
        //     foreach($demande as $demandes){
        //         if($demande->quantité){
                    
        //         }
        //     }
        // }
    }

}
