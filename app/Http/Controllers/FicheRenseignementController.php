<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FicheRenseignement;
use App\Article;
class FicheRenseignementController extends Controller
{
    public function enregistrer(Request $request){

        $fiche = FicheRenseignement::create([
            'marque_id' => $request->marque,
            'type_id' => $request->type,
            'moteur_id' => $request->moteur,
            'modèle_id' => $request->modèle,
            'année' => $request->année,
            'chassis' => $request->chassis,
            'détails' => $request->détails
        ]);
        if($fiche){
            foreach ($request->articles as $article) {
                Article::create([
                    'fiche_renseignement_id' => $fiche->id,
                    'nom' => $article
                ]);
            }
        }
        

    }
    public function répertoire(){
        return view('fiche-renseignement.accueil');
    }
    public function all(){
        return $fiches = FicheRenseignement::with(['articles', 'marque', 'type', 'moteur', 'modèle'])->get();
    }

}
