@extends('layouts.app') 

@section('content')
    <voir-produits :commande="{{ $commande }}" :produits="{{ $produits }}"></voir-produits>
@endsection