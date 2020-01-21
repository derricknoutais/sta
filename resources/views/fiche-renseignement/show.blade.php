@extends('layouts.app')


@section('content')
    <div class="container">
        <show-fiche :fiche="{{$fiche}}" inline-template>
            <div class="card col-md-6 offset-md-2 m-1">
                <div class="card-header" :class="fiche.color">
                    <h5 class="mb-0">
                        Requête
                        <span v-if="fiche.marque !== null">@{{ fiche.marque.nom }}</span>
                        <span v-if="fiche.type !== null"> @{{ fiche.type.nom }}</span>
                        <span v-if="fiche.modèle !== null">@{{ fiche.modèle.nom }}</span>
                        <span v-if="fiche.année !== null">@{{ fiche.année }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <p v-if="fiche.marque !== null"><strong>Marque:</strong> <span>@{{ fiche.marque.nom }}</span></p>
                    <p v-if="fiche.type !== null"><strong>Type:</strong><span>@{{ fiche.type.nom }}</span></p>
                    <p v-if="fiche.année !== null"><strong>Année:</strong><span>@{{ fiche.année }}</span></p>
                    <p v-if="fiche.modèle !== null"><strong>Modèle:</strong><span>@{{ fiche.modèle.nom }}</span></p>
                    <p v-if="fiche.moteur !== null"><strong>Moteur:</strong><span>@{{ fiche.moteur.nom }}</span></p>
                    <p v-if="fiche.détails !== null"><strong>Autre details:</strong> <span><a :href="fiche.détails">@{{ fiche.détails }}</a></span></p>
                    <p><strong v-if="fiche.détails !== null">Articles Recherchés:</strong></p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" v-for="article in fiche.articles" >


                            <div class="row">@{{ article.nom }}</div>
                            <div class="row star" @mouseleave="bringTheOriginalLightsBack(article)">
                                <i class="fas fa-star" :class="article.starDup >= 1 ? 'text-warning' : ''" @mouseover="lightTheStars(article ,1)" @click="storeTheStars(article ,1)"></i>
                                <i class="fas fa-star" :class="article.starDup >= 2 ? 'text-warning' : ''" @mouseover="lightTheStars(article ,2)" @click="storeTheStars(article ,2)"></i>
                                <i class="fas fa-star" :class="article.starDup >= 3 ? 'text-warning' : ''" @mouseover="lightTheStars(article ,3)" @click="storeTheStars(article ,3)"></i>
                                <i class="fas fa-star" :class="article.starDup >= 4 ? 'text-warning' : ''" @mouseover="lightTheStars(article ,4)" @click="storeTheStars(article ,4)"></i>
                                <i class="fas fa-star" :class="article.starDup >= 5 ? 'text-warning' : ''" @mouseover="lightTheStars(article ,5)" @click="storeTheStars(article ,5)"></i>
                            </div>
                            <div class="row my-2">

                            </div>
                            <div class="row">
                                <button v-if="article.état === 'enregistré' " type="button" class="btn btn-primary btn-sm py-0 px-1" @click="changerEtat(index, fiche, article, 'commandé')">Commander <i class="fas fa-envelope-open-text    "></i></button>
                                <span v-else-if="article.état === 'commandé' " class="badge badge-success badge-pill py-1"> Commandé <i class="fas fa-clock"></i></span>
                            </div>


                        </li>
                    </ul>
                </div>
            </div>
        </show-fiche>
        

    </div>
@endsection