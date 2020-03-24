<?php

namespace App\Http\Controllers;
use App\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function commander(Article $article){
        $article->update([
            'état' => 'En Commande'
        ]);
    }
    public function all(){
        return Article::all();
    }

    public function nonCommandé(){
        return Article::with('fiche_renseignement', 'fiche_renseignement.marque', 'fiche_renseignement.type', 'fiche_renseignement.moteur')->get();
    }
    public function changerEtat(Request $request, Article $article){
        $article->changeEtat($request->etat);
    }
    public function storeTheStars(Request $request, Article $article){
        $article->update([
            'stars' => $request->stars
        ]);
    }
}
