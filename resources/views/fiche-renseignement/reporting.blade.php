@extends('layouts.app')


@section('content')
    <reporting-renseignement :data_moteur="{{ $rang_moteur }}" :data_type="{{ $rang_type }}" :data_marque="{{ $rang_marque }}"></reporting-renseignement>
@endsection
