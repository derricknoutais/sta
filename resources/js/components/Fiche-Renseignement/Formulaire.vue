<template>
    <div class="container-fluid">
        <h1 class="text-center">Fiche de Renseignement</h1>
        <div class="row my-3">
            <div class="col-md-4 offset-md-4 col-12">
                <label for="">Ajoute des véhicules</label>
                <div class="input-group">    
                    <select class="custom-select" id="inputGroupSelect04" @change="displayModal(modal.ajouter)" v-model="modal.ajouter">
                        <option selected>Ajouter...</option>
                        <option value="#marque">Ajouter Marque</option>
                        <option value="#type">Ajouter Type</option>
                        <option value="#modèle">Ajouter Modèle</option>
                        <option value="#moteur">Ajouter Moteur</option>
                        <option value="#moteur_type">Attribuer un Moteur à un Type</option>
                        <option value="#modèle_type">Attribuer un Modèle à un Type</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 offset-md-4 border p-3 bg-primary col-10 offset-1">
                <h1 class="text-center mt-5">Fiche de Renseignement</h1>
                <div class="form-group">
                    <label>Marque</label>
                    <select type="text" class="form-control" v-model="fiche_renseignement.marque" @change="chercheType(fiche_renseignement.marque)">
                        <option :value="marque.id" v-for="marque in marques">{{ marque.nom }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <select type="text" class="form-control" v-model="fiche_renseignement.type" @change="chercheMoteurs()">
                        <option :value="type.id" v-for="type in types">{{ type.nom }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Modèle</label>
                    <select type="text" class="form-control" v-model="fiche_renseignement.modèle">
                        <option :value="modèle.id" v-for="modèle in modèles" @change="chercheMoteurs()">{{ modèle.nom }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Moteur</label>
                    <select type="text" class="form-control" v-model="fiche_renseignement.moteur" >
                        <option :value="moteur.id" v-for="moteur in moteurs">{{ moteur.nom }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Année</label>
                    <input type="text" class="form-control" v-model="fiche_renseignement.année">
                </div>
                <div class="form-group">
                    <label>Numéro de Chassis</label>
                    <input type="text" class="form-control" v-model="fiche_renseignement.chassis">
                </div>
                <div class="form-group">
                    <label>Autre details</label>
                    <input type="text" class="form-control" v-model="fiche_renseignement.détails">
                </div>
                <div class="form-group">
                    <label class="d-block">Articles Recherchés</label>
                    <div class="input-group">
                        <input type="text" class="form-control" v-model="fiche_renseignement.article">
                        <div class="input-group-append">
                          <button class="btn btn-outline-success text-white" type="button" @click="ajouterArticles()">Ajouter</button>
                        </div>
                    </div>
                </div>
                <ol class="list-group list-group-flush offset-md-1 col-md-6 mt-5">
                    <li class="list-group-item" v-for="article in fiche_renseignement.articles">{{ article }}</li>
                </ol>
                <div class="row justify-content-center mt-5">
                    <button class="btn btn-success" @click="enregistreLaFiche()">Enregistrer</button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="marque" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter Marque</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input class="form-control" type="text" v-model="formulaire_marque.marque"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"  @click="enregistreUneMarque()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="type" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <select type="text" class="form-control" v-model="formulaire_type.marque" @change="chercheType(formulaire_type.marque)">
                                <option :value="marque.id" v-for="marque in marques">{{ marque.nom }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" v-model="formulaire_type.type"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"  @click="enregistreUnType()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modèle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter Modèle</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <select type="text" class="form-control" v-model="formulaire_modèle.marque">
                                <option :value="marque.id" v-for="marque in marques">{{ marque.nom }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" v-model="formulaire_modèle.modèle"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"  @click="enregistreUnModèle()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="moteur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter Moteur</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <select type="text" class="form-control" v-model="formulaire_moteur.marque" @change="chercheType(formulaire_moteur.marque)">
                                <option :value="marque.id" v-for="marque in marques">{{ marque.nom }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" v-model="formulaire_moteur.moteur" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"  @click="enregistreUnMoteur()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="moteur_type" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Attribuer un Moteur à un Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <select type="text" class="form-control" v-model="formulaire_type_moteur.type">
                                <option :value="type.id" v-for="type in types">{{ type.nom }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select type="text" class="form-control" v-model="formulaire_type_moteur.moteur">
                                <option :value="moteur.id" v-for="moteur in moteurs">{{ moteur.nom }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"  @click="enregistreUnTypeAUnMoteur()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modèle_type" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Attribuer un Modèle à un Type</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <select type="text" class="form-control" v-model="formulaire_modèle_type.type">
                                <option :value="type.id" v-for="type in types">{{ type.nom }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select type="text" class="form-control" v-model="formulaire_modèle_type.modèle">
                                <option :value="modèle.id" v-for="modèle in modèles">{{ modèle.nom }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"  @click="enregistreUnTypeAUnModèle()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>
<script>
export default {
    data(){
        return {
            'fiche_renseignement' : {
                marque: '',
                type: '',
                année: '',
                chassis: '',
                moteur: '',
                autres: '',
                article: '',
                modèle: '',
                articles: []
            },
            "formulaire_marque" : {
                marque: ''
            },
            "formulaire_type" : {
                marque: '',
                type: ''
            },
            "formulaire_moteur" : {
                marque: '',
                moteur: ''
            },
            "formulaire_type_moteur": {
                type: '',
                moteur: ''
            },
            "formulaire_modèle_type": {
                modèle: '',
                type: ''
            },
            "formulaire_modèle": {
                marque: '',
                modèle: ''
            },
            marques: [],
            types: [],
            moteurs: [],
            modèles: [],
            modal:{
                ajouter: '',
                attribuer: ''
            }
        }
    },
    methods: {
        ajouterArticles(){
            this.fiche_renseignement.articles.push(this.fiche_renseignement.article)
        },
        enregistreLaFiche(){
            axios.post('/fiche-renseignement/api/enregistrer', this.fiche_renseignement).then(response => {
                location.reload();
                console.log(response.data);
            }).catch(error => {
                console.log(error);
            });
        },
        chercheType(marque){
            console.log(marque)
            axios.get('/fiche-renseignement/type/de-marque/' + marque).then(response => {
                this.types = response.data;
                console.log(response.data);
            }).catch(error => {
                console.log(error);
            });
        },
        chercheMoteurs(){
            axios.get('/fiche-renseignement/moteur/de-type/' + this.fiche_renseignement.type).then(response => {
                if(response.data.moteurs.length > 0){
                    this.moteurs = response.data.moteurs;
                }
                
            }).catch(error => {
                console.log(error);
            });
            this.chercheModèles();
        },
        chercheModèles(){
            axios.get('/fiche-renseignement/modèle/de-type/' + this.fiche_renseignement.type).then(response => {
                if(response.data.modèles.length > 0){
                    this.modèles = response.data.modèles;
                } else {
                    this.modèles = []
                }
            }).catch(error => {
                console.log(error);
            });
        },
        enregistreUneMarque(){
            axios.post('/fiche-renseignement/marque/api/enregistrer', this.formulaire_marque ).then(response => {
                console.log(response.data);
                location.reload();
                
            }).catch(error => {
                console.log(error);
            });
        },
        enregistreUnType(){
            axios.post('/fiche-renseignement/type/api/enregistrer', this.formulaire_type ).then(response => {
                console.log(response.data);
                location.reload();
            }).catch(error => {
                console.log(error);
            });
        },
        enregistreUnModèle(){
            axios.post('/fiche-renseignement/modèle/api/enregistrer', this.formulaire_modèle ).then(response => {
                console.log(response.data);
                location.reload();
            }).catch(error => {
                console.log(error);
            });
        },
        enregistreUnMoteur(){
            axios.post('/fiche-renseignement/moteur/api/enregistrer', this.formulaire_moteur ).then(response => {
                console.log(response.data);
                location.reload();
            }).catch(error => {
                console.log(error);
            });
        },
        enregistreUnTypeAUnMoteur(){
            axios.post('/fiche-renseignement/type-moteur/api/enregistrer', this.formulaire_type_moteur ).then(response => {
                console.log(response.data);
                location.reload();
            }).catch(error => {
                console.log(error);
            });
        },
        enregistreUnTypeAUnModèle(){
            axios.post('/fiche-renseignement/modèle-type/api/enregistrer', this.formulaire_modèle_type ).then(response => {
                console.log(response.data);
                location.reload();
            }).catch(error => {
                console.log(error);
            });
        },
        displayModal(value){
            $(value).modal('show')
        }
    },
    mounted(){
        axios.get('/fiche-renseignement/marque/api/all').then(response => {
            this.marques = response.data;
            console.log(response.data);
        });
        axios.get('/fiche-renseignement/type/api/all').then(response => {
            console.log(response.data);
            this.types = response.data;
        });
        axios.get('/fiche-renseignement/moteur/api/all').then(response => {
            console.log(response.data);
            this.moteurs = response.data;
        });
        axios.get('/fiche-renseignement/modèle/api/all').then(response => {
            console.log(response.data);
            this.modèles = response.data;
        });
    }
}
</script>
