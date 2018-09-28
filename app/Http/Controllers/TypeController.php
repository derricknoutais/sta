<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Type;
class TypeController extends Controller
{
    public function all(){
        return Type::all();
    }
    public function chercheModèle($marque){
        return Type::where('marque_id', $marque)->get();
    }
    public function enregistrer(Request $request){
        Type::create([
            'marque_id' => $request->marque,
            'nom' => $request->type
        ]);
    }
}
