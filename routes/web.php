<?php
Auth::loginUsingId(1);
Auth::routes();


Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/', function () {
        return view('welcome');
    });
    Route::prefix('/fiche-renseignement')->group(function(){
        Route::get('reporting', 'FicheRenseignementController@reporting');

        Route::get('/', 'FicheRenseignementController@répertoire');

        Route::view('/renseigner', 'fiche-renseignement.renseigner');

        Route::prefix('/api')->group(function(){
            Route::get('/all', 'FicheRenseignementController@all');
            Route::get('/supprimer/{fiche}', 'FicheRenseignementController@supprimer');
            Route::post('/enregistrer', 'FicheRenseignementController@enregistrer');
            Route::post('/update', 'FicheRenseignementController@update');
            Route::post('/articles/commander/{article}', 'ArticleController@modifier');
            Route::post('/articles/changer-etat/{article}', 'ArticleController@changerEtat');
            Route::post('/articles/{article}/store-the-stars', 'ArticleController@storeTheStars');
            
        });
        Route::prefix('/marque')->group(function(){
            Route::view('créer', 'fiche-renseignement.marque.créer');
            Route::prefix('/api')->group(function(){
                Route::get('/all', 'MarqueController@all');
                Route::post('/enregistrer', 'MarqueController@enregistrer');
            });
        });
        Route::prefix('/type')->group(function(){
            Route::get('/de-marque/{marque}', 'TypeController@chercheModèle');
            Route::prefix('/api')->group(function(){
                Route::get('/all', 'TypeController@all');
                Route::post('/enregistrer', 'TypeController@enregistrer');
            });
        });
        Route::prefix('/modèle')->group(function(){
            Route::get('/de-type/{type}', 'ModèleController@chercheModèle');
            Route::prefix('/api')->group(function(){
                Route::get('/all', 'ModèleController@all');
                Route::post('/enregistrer', 'ModèleController@enregistrer');
            });
        });
        Route::prefix('/type-moteur')->group(function(){
            Route::prefix('/api')->group(function(){
                Route::post('/enregistrer', 'TypeMoteurController@enregistrer');
            });
        });
        Route::prefix('/moteur')->group(function(){
            Route::get('/de-type/{type}', 'MoteurController@chercheMoteurs')->where('type', '[0-9]+');
            Route::prefix('/api')->group(function(){
                Route::get('/all', 'MoteurController@all');
                Route::post('/enregistrer', 'MoteurController@enregistrer');
            });
        });
        Route::prefix('/modèle-type')->group(function(){
            Route::prefix('/api')->group(function(){
                // Route::get('/all', 'MoteurController@all');
                Route::post('/enregistrer', 'ModèleTypeController@enregistrer');
            });
        });
    });

    Route::prefix('/commande')->group(function(){
        Route::view('nouvelle', 'commande.nouvelle');
        Route::view('répertoire', 'commande.répertoire');
        Route::get('{commande}', 'CommandeController@voir');
        Route::prefix('/api')->group(function(){
            Route::post('commander', 'CommandeController@commander');
            Route::get('all', 'CommandeController@all');
            Route::post('nouvelle', 'CommandeController@nouvelle');
        });
        Route::get('/{commande}/produits', 'CommandeController@voirProduits');
        Route::post('/{commande}/ajouteProduit', 'CommandeController@ajouteProduits');
        Route::post('/{commande}/ajouteArticle', 'CommandeController@ajouteArticles');
    });
    Route::prefix('/article')->group(function(){
        Route::prefix('/api')->group(function(){
            Route::get('all', 'ArticleController@all');
        });
    });

    Route::prefix('/demande-achat')->group(function(){
        Route::prefix('/api')->group(function(){
            Route::get('all', 'DemandeAchatController@all');
            Route::get('créerDemandesParFournisseur/{commande}', 'DemandeAchatController@créerDemandesParFournisseur');
            Route::post('creer', 'DemandeAchatController@creer');
            Route::post('enregistrer-coût', 'DemandeAchatController@enregistrerCoût');
            Route::post('ajouter-quantité', 'DemandeAchatController@ajouterQuantité');
        });
        Route::view('nouvelle', 'demande-achat.nouvelle' );
        Route::view('répertoire', 'demande-achat.répertoire');
        Route::get('{demande}', 'DemandeAchatController@voir');
    });

    Route::prefix('/bon-commande')->group(function(){
        Route::prefix('/api')->group(function(){
            Route::get('all', 'BonCommandeController@all');
            Route::get('créerCommandes/{commande}', 'BonCommandeController@créerCommandes');
        });
        Route::view('répertoire', 'bon-commande.répertoire');
        Route::get('{commande}', 'BonCommandeController@voir');
    });

    Route::prefix('/produits-commande')->group(function(){
        Route::get('/{produitcommande}/destroy', 'ProduitCommandeController@destroy');
        Route::prefix('api')->group(function(){
            Route::post('upload', 'ProduitCommandeController@upload');
            Route::get('all/{commande}', 'ProduitCommandeController@all');
        });
    });

    Route::prefix('/fournisseur')->group(function(){
        Route::prefix('/api')->group(function(){
            Route::get('all', 'FournisseurController@all');
        });
        Route::view('nouveau', 'demande-achat.nouvelle' );
        Route::view('répertoire', 'demande-achat.répertoire');
    });

    Route::prefix('/produits')->group(function(){
        Route::prefix('api')->group(function(){
            Route::get('all', 'ProduitController@all');
        });
    });
});




