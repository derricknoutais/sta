<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use App\BonCommande;
use App\BonCommandeProduit;
use App\DemandeAchat;
use App\DemandeAchatProduit;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;



class CreeLesBons extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        for($i=0; $i<sizeof($models); $i++)
        {
            $models->load('produits');
            // Pour chaque produit de la demande
            foreach( $models[$i]['produits'] as $produit ){

                $models->load('produits');
                //Vérifie que le produit n'est pas encore checké
                if( $produit['pivot']['checked'] == 0){
                    // Retiens produit
                    $bcp = $produit;
                    $moinsCher = $produit['pivot']['coût'];
                    $fournisseur_id = $models[$i]['fournisseur_id'];
                    $model_id = $models[$i]['id'];

                    for($j=0; $j<sizeof($models); $j++){
                        if($j != $i){
                            foreach($models[$j]['produits'] as $autreproduit){
                                if($produit['id'] == $autreproduit['id']){
                                    if($moinsCher > $autreproduit['pivot']['coût']){
                                        $bcp = $autreproduit;
                                        $moinsCher = $autreproduit['pivot']['coût'];
                                        $fournisseur_id = $models[$j]['fournisseur_id'];
                                        $model_id = $models[$j]['id'];
                                    }
                                    DemandeAchatProduit::find($autreproduit['pivot']['id'])->update([
                                        'checked' => 1
                                    ]);
                                }
                            } 
                        }
                    }
                    if( $bc = BonCommande::where('demande_achat_id',$model_id)->first() ){
                        BonCommandeProduit::create([
                            'bon_commande_id' => $bc->id,
                            'produit_id' => $bcp['id'],
                            'coût' => $moinsCher
                        ]);
                    } else {
                        $bc = BonCommande::create([
                            'numéro' => '',
                            'fournisseur_id' => $fournisseur_id ,
                            'demande_achat_id' => $model_id,
                            'fournisseur_id' => $fournisseur_id,
                            'commande_id' => $models[$i]['commande_id']
                        ]);
                        BonCommandeProduit::create([
                            'bon_commande_id' => $bc->id,
                            'produit_id' => $bcp['id'],
                            'coût' => $moinsCher
                        ]);
                    }
                    DemandeAchatProduit::find($produit['pivot']['id'])->update([
                        'checked' => 1
                    ]);
                }
            }
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
