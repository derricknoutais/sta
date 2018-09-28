<?php
Auth::routes();


Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/', function () {
        return view('welcome');
    });

    Route::prefix('/fiche-renseignement')->group(function(){

        Route::get('/', 'FicheRenseignementController@répertoire');
        Route::view('/renseigner', 'fiche-renseignement.renseigner');
        Route::prefix('/api')->group(function(){
            Route::get('all', 'FicheRenseignementController@all');
            Route::post('/enregistrer', 'FicheRenseignementController@enregistrer');
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
            Route::get('de-type/{type}', 'MoteurController@chercheMoteurs')->where('modele', '[0-9]+');
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
});




