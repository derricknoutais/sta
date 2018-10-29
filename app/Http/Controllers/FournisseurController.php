<?php

namespace App\Http\Controllers;
use App\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function all(){
        return Fournisseur::all();
    }
}
