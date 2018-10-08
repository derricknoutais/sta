<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marque;
class MarqueController extends Controller
{
    public function all(){
        return Marque::orderBy('nom')->get();
    }
    public function enregistrer(Request $request){
        Marque::create([
            'nom' => $request->marque
        ]);
    }
}
