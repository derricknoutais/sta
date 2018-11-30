<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FicheRenseignement;
use App\Article;
use DB;
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
        return $fiches = FicheRenseignement::with(['articles', 'marque', 'type', 'moteur', 'modèle'])->orderBy('created_at','desc')->get();
    }

    public function reporting(){
        $rang_marque = FicheRenseignement::select(DB::raw('count(*) as marque_count, marque_id'))->with('marque')->groupBy('marque_id')->orderBy('marque_count', 'DESC')->get();
        $rang_type = FicheRenseignement::select(DB::raw('count(*) as type_count, type_id'))->with('type')->groupBy('type_id')->orderBy('type_count', 'DESC')->get();
        $rang_moteur = FicheRenseignement::select(DB::raw('count(*) as moteur_count, moteur_id'))->with('moteur')->groupBy('moteur_id')->orderBy('moteur_count', 'DESC')->get();
        return view('fiche-renseignement.reporting', compact('rang_marque', 'rang_type', 'rang_moteur'));
    }

}
