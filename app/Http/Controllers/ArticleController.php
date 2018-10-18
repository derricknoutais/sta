<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function commander(Article $article){
        $article->update([
            'état' => 'En Commande'
        ]);
    }
}
