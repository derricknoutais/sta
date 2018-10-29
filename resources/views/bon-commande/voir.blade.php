@extends('layouts.app') 

@section('content')
    <voir-bon-commande :data="{{ $commande }}"></voir-bon-commande>
@endsection