<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\BelongsTo;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

class DemandeAchat extends Resource
{
    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = [];
    
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\DemandeAchat';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'numéro';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'numéro'
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
            ID::make()->sortable(),
            BelongsToMany::make('Produits')
                ->searchable()
                ->fields(function(){
                    return [
                        Text::make('coût')
                    ];
                }),
            Text::make('numéro'),
            BelongsTo::make('fournisseur')
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
            new Actions\CreeLesBons
        ];
    }
}
