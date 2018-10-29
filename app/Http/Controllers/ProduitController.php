<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produit;
class ProduitController extends Controller
{
    public function all(){
        return Produit::all();
    }
}
