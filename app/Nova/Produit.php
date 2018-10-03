<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Currency;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

class Produit extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Produit';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'nom';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'sku', 'nom',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('sku')->sortable(),
            Text::make('nom', function(){
                if( $this->variante_deux != ''){
                    if( $this->variante_trois != ''){
                        return $this->nom . ' / ' . $this->variante_une . ' / ' . $this->variante_deux . ' / ' . $this->variante_trois;
                    }
                        return $this->nom . ' / ' . $this->variante_une . ' / ' . $this->variante_deux ;
                    
                } else {
                    return $this->nom . ' / ' . $this->variante_une ;
                }
                
            })->sortable(),
            BelongsToMany::make('demandeAchat'),
            BelongsToMany::make('bonCommande'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new Actions\AjouterProduitsADemande
        ];
    }
}
