@extends('layouts.app') 

@section('content')
    <voir-produits 
        :commande="{{ $commande }}" 
        :produits="{{ $produits }}"
        :articles="{{ $articles }}" >
    </voir-produits>
@endsection