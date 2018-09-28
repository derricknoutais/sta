<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marque;
class MarqueController extends Controller
{
    public function all(){
        return Marque::all();
    }
    public function enregistrer(Request $request){
        Marque::create([
            'nom' => $request->marque
        ]);
    }
}
