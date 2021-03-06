@extends('layouts.app')


@section('content')
    <voir-commande :data="{{ $commande }}" inline-template>
        <div>

            

            {{-- <div class="card mt-5">
                <div class="card-header text-center">
                    <div class="row">
                        <div class="col-md-3">
                            <input class="form-control" type="file" id="file" ref="file" @change="uploadData()"/>
                        </div>
                        <div class="col-md-3 text-center">
                            <h5>Liste des Produits Commandés</h5>
                        </div>
                        <div class="col-md-6 text-right">  
                            <button class="btn btn-primary" type="button" id="triggerId" data-toggle="dropdown">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="triggerId">
                                <a target="_blank" class="dropdown-item" href="/nova/resources/produits">
                                    Ajouter Produits
                                    </a>
                                <a class="dropdown-item" :href="'/commande/' + this.data.id + '/produits'">
                                    <i class="fas fa-expand-arrows-alt"></i>
                                    Plein Écran
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height:30em;overflow-y: scroll;">
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>Numéro</th>
                                <th>SKU</th>
                                <th>Désignation</th>
                                <th>Quantité</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(produit, index) in produits_commande">
                                <td>@{{ index + 1 }}</td>
                                <td scope="row">@{{ produit.produit.sku }}</td>
                                <td>@{{ produit.produit.nom + ' / ' + produit.produit.variante_une + ' / ' + produit.produit.variante_deux + ' / ' + produit.produit.variante_trois }}</td>
                                <td></td>
                                <td><button class="btn btn-danger" data-toggle="modal" data-target="#confirmDelete" @click="ajouterProduitASupprimer(produit, index)"><i class="fas fa-times-circle"></i></button></td>
                            </tr>
                            <tr>
                                <td scope="row"></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mt-5" >
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <button class="btn btn-primary" @click="créerDemandesParFournisseur()">Créer les Demandes</button>
                        </div>
                        <div class="col-md-6 text-center">
                            <h5>Demandes Envoyés</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height:30em;overflow-y: scroll;">
                    <table class="table table-striped table-inverse mt-3">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Numéro</th>
                                <th>Fournisseur</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="demande in this.data.demandes">
                                    <td scope="row"><a :href="'/demande-achat/' + demande.id">@{{ demande.numéro }}</a></td>
                                    <td scope="row">@{{ demande.fournisseur.nom }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                    </table>
                </div>
            </div>
            <div class="card mt-5">
                <div class="card-header text-center">
                    <div class="row">
                        <div class="col-md-3">
                            <button class="btn btn-primary" @click="créerCommandes()">Créer les Commandes</button>
                        </div>
                        <div class="col-md-6 text-center">
                            <h5>Bons de Commande</h5>
                        </div>
                    </div>

                </div>
                <div class="card-body" style="max-height:30em;overflow-y: scroll;">
                    <table class="table table-striped table-inverse mt-5">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Numéro</th>
                                <th>Fournisseur</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="commande in data.commandes">
                                    <td scope="row"><a :href="'/bon-commande/' + commande.id">BC00@{{ commande.commande_id }}</a></td>
                                    <td scope="row">@{{ commande.fournisseur.nom }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                    </table>
                </div>
            </div>

            <!-- Confirm Delete Modal -->
            <div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Supprimer Produit</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div class="modal-body">
                            Voulez-vous vraiment supprimer le produit sélectionné
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" @click="supprimerProduit()">Supprimer</button>
                        </div>
                    </div>
                </div>
            </div> --}}



            <h2 class="text-center mt-5">@{{ data.nom }}</h2>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-2">
                        <a href="/commande/{{ $commande->id }}/playground" class="btn btn-primary btn-block">
                            <i class="fas fa-gamepad"></i>
                            Acceder au Playground
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </voir-commande>
@endsection