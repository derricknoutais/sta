<?php

namespace App\Nova\Actions;

use App\DemandeAchat;
use App\DemandeAchatProduit;
use Laravel\Nova\Fields\Select;
use Silvanite\NovaFieldCheckboxes\Checkboxes;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AjouterProduitsADemande extends Action
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
        foreach($models as $produit){
            foreach($fields->demande as $demande){
                DemandeAchatProduit::create([
                    'demande_achat_id' => $demande,
                    'produit_id' => $produit->id
                ]);
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
        $demandes = DemandeAchat::pluck('numéro', 'id')->toArray();

        return [
            // Select::make('demande')->options($demandes)
            Checkboxes::make('demande')->options($demandes)
        ];
    }
}
