<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="float-right">
                    <a class="btn btn-primary" href="/fiche-renseignement/renseigner">Ajouter une Requête</a>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-2">
                <select class="form-control" v-model="filtre_marque" @change="chercheTypes(filtre_marque)">
                    <option value="marque">Sélectionne une Marque</option>
                    <option :value="marque.id" v-for="marque in marques" v-if="marque !== null">{{ marque.nom }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control" v-model="filtre_type" @change="chercheMoteurs()">
                    <option value="type">Sélectionne un Type</option>
                    <option :value="type.id" v-for="type in types" v-if="type !== null">{{ type.nom }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control" v-model="filtre_moteur">
                    <option value="moteur">Sélectionne un Moteur</option>
                    <option :value="moteur.id" v-for="moteur in this.filtered_moteurs" v-if="moteur !== null">{{ moteur.nom }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control" v-model="filtre_modele">
                    <option value="modèle">Sélectionne un Modèle</option>
                    <option :value="modèle.id" v-for="modèle in this.modèles" v-if="modèle !== null">{{ modèle.nom }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary" @click="réinitialiser()">Réinitialiser Filtres</button>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-md-4">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                  Creer demande
                </button>
            </div> 
            <div class="col-md-2 offset-md-6 text-right">
                <button @click="changeView('Liste')" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Mode Liste"><i class="fas fa-bars mx-1"></i></button>
                <button @click="changeView('Carte')" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Mode Carte"><i class="fas fa-grip-horizontal fa-1x mx-1"></i></button>
            </div>
        </div>
        <div class="row" v-if="this.viewMode === 'Liste'">
            <div class="col-md-6" id="accordion"s>
                <div class="card" v-for="(fiche, index) in filtered">
                    <div class="card-header" >
                        <div class="mb-0 row">
                            <div class="col-md-10 border-right" data-toggle="collapse" :data-target="'#fiche'+index">
                                Requête
                                <span v-if="fiche.marque !== null">{{ fiche.marque.nom }}</span>
                                <span v-if="fiche.type !== null"> {{ fiche.type.nom }}</span>
                                <span v-if="fiche.modèle !== null">{{ fiche.modèle.nom }}</span>
                                <span v-if="fiche.année !== null">{{ fiche.année }}</span>
                            </div>
                            <div class="col-md-2 text-right">
                                <a href="#" @click="selectionneLaModification(fiche)" data-toggle="modal" data-target="#editerRequeteModal"><i class="far fa-edit text-primary mr-3"></i></a>
                                <a href="#" @click="selectionneLaSuppression(fiche)" data-toggle="modal" data-target="#confirmerSuppressionModal"><i class="fas fa-trash-alt text-danger"></i></a>
                            </div>

                        </div>
                    </div>
                    <div :id="'fiche' + index" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            <p><strong>Marque:</strong> <span v-if="fiche.marque !== null">{{ fiche.marque.nom }}</span></p>
                            <p ><strong>Type:</strong> <span v-if="fiche.type !== null">{{ fiche.type.nom }}</span></p>
                            <p ><strong>Année:</strong> <span v-if="fiche.année !== null">{{ fiche.année }}</span></p>
                            <p><strong>Modèle:</strong> <span  v-if="fiche.modèle !== null">{{ fiche.modèle.nom }}</span></p>
                            <p><strong>Moteur:</strong> <span v-if="fiche.moteur !== null">{{ fiche.moteur.nom }}</span></p>
                            <p><strong>Autre details:</strong> <span v-if="fiche.détails !== null">{{ fiche.détails }}</span></p>
                            <p><strong v-if="fiche.détails !== null">Articles Recherchés:</strong></p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item" v-for="article in fiche.articles" >
                                    <input type="checkbox" @click="selectionneArticle(article)" v-if="! article.commandé">
                                    {{ article.nom }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        <div class="row" v-if="this.viewMode === 'Carte'">
            <div class="card col-md-3 m-1" v-for="(fiche, index) in filtered">
                <div class="card-header">
                    <h5 class="mb-0">
                        Requête
                        <span v-if="fiche.marque !== null">{{ fiche.marque.nom }}</span>
                        <span v-if="fiche.type !== null"> {{ fiche.type.nom }}</span>
                        <span v-if="fiche.modèle !== null">{{ fiche.modèle.nom }}</span>
                        <span v-if="fiche.année !== null">{{ fiche.année }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <p v-if="fiche.marque !== null"><strong>Marque:</strong> <span>{{ fiche.marque.nom }}</span></p>
                    <p v-if="fiche.type !== null"><strong>Type:</strong><span>{{ fiche.type.nom }}</span></p>
                    <p v-if="fiche.année !== null"><strong>Année:</strong><span>{{ fiche.année }}</span></p>
                    <p v-if="fiche.modèle !== null"><strong>Modèle:</strong><span>{{ fiche.modèle.nom }}</span></p>
                    <p v-if="fiche.moteur !== null"><strong>Moteur:</strong><span>{{ fiche.moteur.nom }}</span></p>
                    <p v-if="fiche.détails !== null"><strong>Autre details:</strong> <span>{{ fiche.détails }}</span></p>
                    <p><strong v-if="fiche.détails !== null">Articles Recherchés:</strong></p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" v-for="article in fiche.articles" >
                            <input type="checkbox" @click="selectionneArticle(article)" v-if="! article.commandé">
                            {{ article.nom }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sélectionne Demande</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6" v-for="demande in commandes">
                                <input type="checkbox" @click="selectionneDemande(demande)">
                                <label>{{ demande.nom }}</label>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="commander()">Ajouter à Demande</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editerRequeteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" @keyup.enter="supprimeLaRequete(aSupprimer)" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Marque</label>
                            <select type="text" class="form-control" v-if="aEditer" v-model="fiche_renseignement.marque" @change="chercheTypesEdit(fiche_renseignement.marque)">
                                <option :value="marque.id" v-for="marque in marques">{{ marque.nom }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Type</label>
                            <select type="text" class="form-control" v-model="fiche_renseignement.type" @change="chercheMoteursEdit()">
                                <option :value="type.id" v-for="type in fiche_renseignement.types">{{ type.nom }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Modèle</label>
                            <select type="text" class="form-control" v-model="fiche_renseignement.modèle">
                                <option :value="modèle.id" v-for="modèle in fiche_renseignement.modèles" @change="chercheMoteursEdit()">{{ modèle.nom }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Moteur</label>
                            <select type="text" class="form-control" v-model="fiche_renseignement.moteur" >
                                <option :value="moteur.id" v-for="moteur in fiche_renseignement.moteurs">{{ moteur.nom }}</option>
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
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <h5 class="">Articles Recherchés
                                <a href="#" v-if="!editerArticles" @click="toggleEditArticles()"><i class="far fa-edit text-primary mx-3"></i></a>
                            </h5>
                        </div>
                    </div>
                    
                    <ol class="list-group list-group-flush offset-md-1 col-md-6 mt-2 " v-if="aEditer">
                        <li class="list-group-item" v-if="aEditer.articles && !editerArticles" v-for="(article, index) in aEditer.articles">{{ article.nom }}</li>
                        <div class="row" v-for="(article, index) in aEditer.articles">
                            <div class="col-md-10" v-if="aEditer.articles && editerArticles">
                                <input class="form-control d-inline-block" v-if="aEditer" v-model="aEditer.articles[index].nom">
                            </div>
                            <div class="col-md-2" v-if="editerArticles" >
                                <a href="#" class="d-inline-block" @click=""><i class="far fa-save text-success mx-3"></i></a>
                            </div>
                        </div>
                    </ol>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="supprimeLaRequete(aSupprimer)">Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="confirmerSuppressionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" @keyup.enter="supprimeLaRequete(aSupprimer)" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Attention</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                Êtes-Vous sûr de vouloir supprimer cette requête. Cette action est irréversible.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="supprimeLaRequete(aSupprimer)">Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="succèsSuppression" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Attention</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                La requête a été supprimée avec succès
                            </div>
                        </div>
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
                articles: [],
                types: [],
                marques: [],
                moteurs: [],
                modèles:[]
            },
            filtre_marque: 'marque',
            filtre_type: 'type',
            filtre_moteur: 'moteur',
            filtre_modele: 'modèle',
            filtre : {
                marque: '',
                type: ''
            },
            fiches: [],
            marques: [],
            types : [],
            types_moteurs: [],
            moteurs : {
                moteurs : []
            },
            filtered: [],
            filtered_moteurs: [],
            modèles: [],
            selectionArticles: [],
            demandes: [],
            selectionDemandes: [],
            commandes: [],
            viewMode: 'Liste',
            aSupprimer: null,
            aEditer: null,
            editerArticles: false
        }
    },
    methods: {
        chercheTypes(marque){
            console.log(marque)
            axios.get('/fiche-renseignement/type/de-marque/' + marque).then(response => {
                this.fiche_renseignement.type = this.types = response.data;
                console.log(response.data);
            }).catch(error => {
                console.log(error);
            });
        },
        chercheMoteurs(){
            axios.get('/fiche-renseignement/moteur/de-type/' + this.filtre_type).then(response => {
                this.fiche_renseignement.moteur = this.moteurs.moteurs = response.data;
            }).catch(error => {
                console.log(error);
            });
            this.chercheModèles();
        },
        chercheModèles(){
            axios.get('/fiche-renseignement/modèle/de-type/' + this.filtre_modèle).then(response => {
                this.filtre_modele = this.modèles = response.data;
            }).catch(error => {
                console.log(error);
            });
        },
        chercheTypesEdit(marque){
            console.log(marque)
            axios.get('/fiche-renseignement/type/de-marque/' + marque).then(response => {
                this.fiche_renseignement.types = response.data;
                console.log(response.data);
            }).catch(error => {
                console.log(error);
            });
        },
        chercheMoteursEdit(){
            axios.get('/fiche-renseignement/moteur/de-type/' + this.fiche_renseignement.type).then(response => {
                this.fiche_renseignement.moteurs = response.data.moteurs;
            }).catch(error => {
                console.log(error);
            });
            this.chercheModèlesEdit();
        },
        chercheModèlesEdit(){
            axios.get('/fiche-renseignement/modèle/de-type/' + this.fiche_renseignement.type).then(response => {
                this.fiche_renseignement.modèles = response.data.modèles;
            }).catch(error => {
                console.log(error);
            });
        },
        réinitialiser(){
            this.filtered = this.fiches
            this.filtre_marque = 'marque'
            this.filtre_type = 'type'
            this.filtre_moteur = 'moteur'
            this.filtre_modele = 'modèle'
            this.filtered_moteurs = this.moteurs.moteurs
        },
        selectionneArticle(article){
            this.selectionArticles.push(article)
        },
        selectionneDemande(demande){
            this.selectionDemandes.push(demande)
        },
        commander(){
            axios.post('/commande/api/commander', {commandes: this.selectionDemandes, articles: this.selectionArticles} ).then(response => {
                console.log(response.data);
            }).catch(error => {
                console.log(error);
            });
        },
        changeView(mode){
            this.viewMode = mode;
        },
        selectionneLaSuppression(fiche){
            this.aSupprimer = fiche
        },
        selectionneLaModification(fiche){
            this.aEditer = fiche
        },
        supprimeLaRequete(fiche){
            axios.get('fiche-renseignement/api/supprimer/' + fiche.id)
            .then(response => {
                console.log(response.data);
                $('#confirmerSuppressionModal').modal('hide')
                $('#succèsSuppression').modal('show')
                setTimeout(function(){ 
                    $('#succèsSuppression').modal('hide')
                    
                }, 2000);
                this.init();
            }).catch(error => {
                console.log(error);
            });
            
        },
        toggleEditArticles(){
            this.editerArticles = ! this.editerArticles;
        },
        init(){
            axios.get('fiche-renseignement/api/all').then(response => {
                this.fiches = this.filtered = response.data   
            });
            axios.get('fiche-renseignement/marque/api/all').then(response => {
                this.marques = response.data;
            });
            axios.get('fiche-renseignement/type/api/all').then(response => {
                this.types = response.data;
            });
            axios.get('fiche-renseignement/moteur/api/all').then(response => {
                this.filtered_moteurs = this.moteurs.moteurs = response.data;
            });
            axios.get('fiche-renseignement/modèle/api/all').then(response => {
                this.modèles = response.data;
            });
            axios.get('demande-achat/api/all').then(response => {
                this.demandes = response.data;
            });
            axios.get('commande/api/all').then(response => {
                this.commandes = response.data;
            });
            axios.get('/fiche-renseignement/moteur/api/all').then(response => {
                this.moteurs.moteurs = response.data;
            });
        }
    },
    watch: {
        filtre_marque(){
            console.log('hello')
            if(this.filtre_marque !== 'marque'){
                this.filtered = this.fiches.filter( (each) => {
                    return each.marque_id === this.filtre_marque
                });
                this.filtered_moteurs = this.moteurs.moteurs.filter( (each) => {
                    return each.marque_id === this.filtre_marque
                });
            }
        },
        filtre_type(){
            console.log('hello')
            if(this.filtre_type !== 'type'){
                this.filtered = this.fiches.filter( (each) => {
                    return each.type_id === this.filtre_type
                })
            }
            
        },
        filtre_moteur(){
            if(this.filtre_moteur !== 'moteur'){
                this.filtered = this.fiches.filter( (each) => {
                    return each.moteur_id === this.filtre_moteur
                })
            }
        },
        filtre_modele(){
            if(this.filtre_modele !== 'modèle'){
                this.filtered = this.fiches.filter( (each) => {
                    return each.modèle_id === this.filtre_modele
                })
            }
        },
    },
    mounted(){
        this.init();
    }
}
</script>

<style>
    .form-control {
        display: inline-block;
    }
</style>