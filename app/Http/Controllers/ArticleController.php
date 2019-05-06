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
    public function changerEtat(Request $request, Article $article){
        $article->changeEtat($request->etat);
    }
}
