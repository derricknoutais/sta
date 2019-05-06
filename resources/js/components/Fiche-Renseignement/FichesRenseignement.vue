<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="float-right">
                    
                </div>
            </div>
        </div>
        <!-- Input Filtres -->
        <div class="row mt-5">
            <div class="col-md-3">
                <!-- <select class="form-control" v-model="filtre_marque" @change="chercheTypes(filtre_marque)">
                    <option value="marque">Sélectionne une Marque</option>
                    <option :value="marque.id" v-for="marque in marques" v-if="marque !== null">{{ marque.nom }}</option>
                </select> -->
                <label>Marque</label>
                <multiselect v-model="filtre_marque" :options="this.marques" label="nom" track-by="id" placeholder="Select one" @select="chercheTypes()">
                    <template slot="singleLabel" slot-scope="{ option }" :value="option.id"><strong>{{ option.nom }}</strong></template>
                </multiselect>
            </div>
            <div class="col-md-3">
                <!-- <select class="form-control" v-model="filtre_type" @change="chercheMoteurs()">
                    <option value="type">Sélectionne un Type</option>
                    <option :value="type.id" v-for="type in types" v-if="type !== null">{{ type.nom }}</option>
                </select> -->
                <label>Type</label>
                <multiselect v-model="filtre_type" :options="this.types" label="nom"  @select="chercheMoteurs()">
                    <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.nom }}</strong></template>
                </multiselect>
            </div>
            <div class="col-md-3">
                <!-- <select class="form-control" v-model="filtre_moteur">
                    <option value="moteur">Sélectionne un Moteur</option>
                    <option :value="moteur.id" v-for="moteur in this.moteurs" v-if="moteur !== null">{{ moteur.nom }}</option>
                </select> -->
                <label>Moteur</label>
                <multiselect v-model="filtre_moteur" :options="this.moteurs" label="nom"  @select="chercheMoteurs()">
                    <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.nom }}</strong></template>
                </multiselect>
            </div>
            <div class="col-md-3">
                <!-- <select class="form-control" v-model="filtre_modele">
                    <option value="modèle">Sélectionne un Modèle</option>
                    <option :value="modèle.id" v-for="modèle in this.modèles" v-if="modèle !== null">{{ modèle.nom }}</option>
                </select> -->
                <label>Modèle</label>
                <multiselect v-model="filtre_modele" :options="this.modèles" label="nom"  @select="chercheMoteurs()">
                    <!-- <template slot="singleLabel" slot-scope="{ option }"><strong>{{ option.nom }}</strong></template> -->
                </multiselect>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-3">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="" id="" value="checkedValue" checked>
                    Archivé
                  </label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="" id="" value="checkedValue">
                    Entièrment Commandé
                  </label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-check">
                  <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="" id="" value="checkedValue">
                    Partiellement Commandé
                  </label>
                </div>
            </div>
            
        </div>
        <!-- Boutons Fonctionnalité -->
        <div class="row my-5">
            <div class="col-md-6">
                <a class="btn btn-success" href="/fiche-renseignement/renseigner"> <i class="fas fa-plus"></i> Ajouter une Requête</a>
                <button class="btn btn-dark" @click="réinitialiser()">Réinitialiser Filtres</button>
                
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                  Creer demande
                </button> -->
            </div>
             
            <div class="col-md-2 offset-md-4 text-right">
                <button @click="changeView('Liste')" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Mode Liste"><i class="fas fa-bars mx-1"></i></button>
                <button @click="changeView('Carte')" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Mode Carte"><i class="fas fa-grip-horizontal fa-1x mx-1"></i></button>
            </div>
        </div>
        
        <div class="row" v-if="this.viewMode === 'Liste'">
            <div class="col-md-6" id="accordion">
                <div class="card" v-for="(fiche, index) in filtered">
                    <div class="card-header "  :class="fiche.color" >
                        <div class="mb-0 row">
                            <div class="col-md-10 border-right" data-toggle="collapse" :data-target="'#fiche'+index">
                                Requête
                                <span v-if="fiche.marque !== null">{{ fiche.marque.nom }}</span>
                                <span v-if="fiche.type !== null"> {{ fiche.type.nom }}</span>
                                <span v-if="fiche.modèle !== null">{{ fiche.modèle.nom }}</span>
                                <span v-if="fiche.année !== null">{{ fiche.année }}</span>
                            </div>
                            <div class="col-md-2 text-right">
                                <a href="#" @click="selectionneLaModification(fiche)" 
                                    data-toggle="modal" data-target="#editerRequeteModal">
                                    <i class="far fa-edit mr-3" :class="fiche.color === 'bg-danger text-white' ? 'text-white' : ''"></i>
                                </a>
                                <a href="#" @click="selectionneLaSuppression(fiche)" 
                                    data-toggle="modal" data-target="#confirmerSuppressionModal">
                                    <i class="fas fa-trash-alt" :class="fiche.color === 'bg-danger text-white' ? 'text-white' : 'text-danger'"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                    <div :id="'fiche' + index" class="collapse" data-parent="#accordion" >
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
                                    <!-- <input type="checkbox" @click="selectionneArticle(article)" v-if="! article.commandé"> -->
                                    <div class="row">{{ article.nom }}</div>
                                    
                                    <button v-if="article.état === 'enregistré' " type="button" class="btn btn-primary btn-sm py-0 px-1" @click="changerEtat(article.id, 'commandé')">Commander <i class="fas fa-envelope-open-text    "></i></button>
                                    <span v-else-if="article.état === 'commandé' " class="badge badge-success badge-pill py-1"> Commandé <i class="fas fa-clock"></i></span>
                                    
                                    <button type="button" class="btn btn-danger btn-sm py-0 px-1" @click="changerEtat(article.id, 'archivé')" >Réceptionner</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        <div class="row" v-if="this.viewMode === 'Carte'">
            <div class="card col-md-3 m-1" v-for="(fiche, index) in filtered">
                <div class="card-header" :class="fiche.color">
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
                            <!-- <input type="checkbox" @click="selectionneArticle(article)" v-if="! article.commandé"> -->
                            <div class="row">{{ article.nom }}</div>

                            <button v-if="article.état === 'enregistré' " type="button" class="btn btn-primary btn-sm py-0 px-1" @click="changerEtat(article.id, 'commandé')">Commander <i class="fas fa-envelope-open-text    "></i></button>
                            <span v-else-if="article.état === 'commandé' " class="badge badge-success badge-pill py-1"> Commandé <i class="fas fa-clock"></i></span>

                            <button type="button" class="btn btn-danger btn-sm py-0 px-1" @click="changerEtat(article.id, 'archivé')" >Réceptionner</button>
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
                            <select type="text" class="form-control" v-if="aEditer" v-model="aEditer.marque_id" @change="chercheTypesEdit(aEditer.marque_id)">
                                <option :value="marque.id" v-for="marque in marques">{{ marque.nom }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Type</label>
                            <select type="text" class="form-control" v-if="aEditer" v-model="aEditer.type_id" @change="chercheMoteursEdit()">
                                <option :value="type.id" v-for="type in types">{{ type.nom }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Modèle</label>
                            <select type="text" class="form-control" v-if="aEditer" v-model="aEditer.modèle_id">
                                <option :value="modèle.id" v-for="modèle in modèles" @change="chercheMoteursEdit()">{{ modèle.nom }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Moteur</label>
                            <select type="text" class="form-control" v-if="aEditer" v-model="aEditer.moteur_id" >
                                <option :value="moteur.id" v-for="moteur in moteurs.moteurs">{{ moteur.nom }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Année</label>
                            <input type="text" class="form-control" v-if="aEditer" v-model="aEditer.année">
                        </div>
                        <div class="form-group">
                            <label>Numéro de Chassis</label>
                            <input type="text" class="form-control" v-if="aEditer" v-model="aEditer.chassis">
                        </div>
                        <div class="form-group">
                            <label>Autre details</label>
                            <input type="text" class="form-control" v-if="aEditer" v-model="aEditer.détails">
                        </div>
                        <div class="form-group">
                            <label class="d-block">Articles Recherchés</label>
                            <div class="input-group">
                                <input type="text" class="form-control" v-if="aEditer" v-model="articleAEditer">
                                <div class="input-group-append">
                                  <button class="btn btn-outline-success text-white" type="button" @click="ajouterArticles()">Ajouter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <h5 class="">Articles Recherchés
                                <a href="#" v-if="!editerArticles" @click="toggleEditArticles()">
                                    <i class="far fa-edit text-primary mx-3"></i>
                                </a>
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
                        <button type="button" class="btn btn-primary" @click="updateRequete()">Modifier</button>
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
import Multiselect from 'vue-multiselect';
export default {
    data(){
        return {
            fiche_renseignement : {
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
            moteurs : [],
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
            articleAEditer: null,
            editerArticles: false
        }
    },
    methods: {
        chercheTypes(){
            setTimeout(() => {
                console.log( 'The id is ' + this.filtre_marque.id)
                axios.get('/fiche-renseignement/type/de-marque/' + this.filtre_marque.id).then(response => {
                    this.types = response.data;
                    console.log(response.data);
                }).catch(error => {
                    console.log(error);
                });
            }, 100);
            
        },
        chercheMoteurs(){
            setTimeout(() => {
                axios.get('/fiche-renseignement/moteur/de-type/' + this.filtre_type.id).then(response => {
                    console.log('Moteur Time ' + this.filtre_type.id)
                    console.log(response.data)
                    this.moteurs  =  response.data.moteurs
                    // this.filtre_moteur = response.data.moteurs
                }).catch(error => {
                    console.log(error);
                });
            }, 1000);
            
            // setTimeout(() => {
            //     this.chercheModèles();
            // }, 3000);
        },
        chercheModèles(){
            axios.get('/fiche-renseignement/modèle/de-type/' + this.filtre_modèle).then(response => {
                this.filtre_modele = this.modèles = response.data;
            }).catch(error => {
                console.log(error);
            });
        },
        chercheTypesEdit(marque){
            axios.get('/fiche-renseignement/type/de-marque/' + marque).then(response => {
                this.types = response.data;
                console.log(response.data);
                this.$forceUpdate();
            }).catch(error => {
                console.log(error);
            });
        },
        chercheMoteursEdit(){
            axios.get('/fiche-renseignement/moteur/de-type/' + this.aEditer.type_id).then(response => {
                this.moteurs.moteurs = response.data.moteurs;
            }).catch(error => {
                console.log(error);
            });
            this.chercheModèlesEdit();
        },
        chercheModèlesEdit(){
            axios.get('/fiche-renseignement/modèle/de-type/' + this.aEditer.type_id).then(response => {
                this.modèles = response.data.modèles;
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
        changerEtat(article, etat){
            axios.post('/fiche-renseignement/api/articles/changer-etat/' + article , { 'etat' : etat }).then(response => {
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
                this.moteurs = response.data;
            });
        },
        updateRequete(){
            axios.post('/fiche-renseignement/api/update', this.aEditer ).then(response => {
                console.log(response.data);
            }).catch(error => {
                console.log(error);
            });
        },
        ajouterArticles(){
            if(this.aEditer && this.articleAEditer){
                this.aEditer.articles.push({nom: this.articleAEditer})
                this.$forceUpdate()
            }
        },
        test(){
            setTimeout(() => {
                console.log(this.filtre_marque.nom)
            }, 10);
            
        },
        ficheColor(fiche){
            var nombreCommandé = 0;
            var nombreArchivé = 0;
            var nombreEnregistré = 0;
            fiche.articles.forEach( (article) => {
                if(article.état === 'commandé'){
                    nombreCommandé += 1
                } else if(article.état === 'archivé'){
                    nombreArchivé += 1
                } else if(article.état === 'enregistré'){
                    nombreEnregistré += 1
                }
            })
            if( nombreCommandé === fiche.articles.length ){
                return 'success'
            } else if( nombreCommandé > 0 && nombreCommandé < fiche.articles.length ){
                return 'danger text-white'
            } else if( nombreCommandé === fiche.articles.length ){
                return 'success'
            } 
        }
    },
    watch: {
        filtre_marque(){
            console.log('I changed')
            if(this.filtre_marque !== 'marque'){
                this.filtered = this.fiches.filter( (each) => {
                    return each.marque_id === this.filtre_marque.id
                });
                this.filtered_moteurs = this.moteurs.filter( (each) => {
                    return each.marque_id === this.filtre_marque.id
                });
            } else {
                axios.get('fiche-renseignement/marque/api/all').then(response => {
                    this.marques = response.data;
                });
            }
        },
        filtre_type(){
            console.log('I changed too')
            if(this.filtre_type !== 'type'){
                this.filtered = this.fiches.filter( (each) => {
                    return each.type_id === this.filtre_type.id
                })
            } else {
                axios.get('fiche-renseignement/type/api/all').then(response => {
                    this.types = response.data;
                });
            }
            
        },
        filtre_moteur(){
            if(this.filtre_moteur !== 'moteur'){
                this.filtered = this.fiches.filter( (each) => {
                    return each.moteur_id === this.filtre_moteur.id
                })
            } else {
                axios.get('fiche-renseignement/moteur/api/all').then(response => {
                    this.filtered_moteurs = this.moteurs.moteurs = response.data;
                });
            }
        },
        filtre_modele(){
            if(this.filtre_modele !== 'modèle'){
                this.filtered = this.fiches.filter( (each) => {
                    return each.modèle_id === this.filtre_modele.id
                })
            }
        },
        filtre_partiellement_commande(){
            if(this.filtre_partiellement_commande === 1){
                this.filtered = this.fiches.filter( (each) => {
                    return each.modèle_id === this.filtre_modele.id
                })
            }
        }
        // filtered(){
        //     this.filtered.forEach(fiche => {
        //         fiche.color = this.ficheColor(fiche)
        //     });
        // }
    },
    computed : {
        
    },
    mounted(){
        this.init();
        setTimeout(() => {
            this.fiches.forEach((fiche) => {
                // console.log(fiche.id)
                fiche.color = 'bg-' + this.ficheColor(fiche)
            });
            this.$forceUpdate()
        }, 3000);
        
    },
    created(){
        
    }
}
</script>

<style>
    .form-control {
        display: inline-block;
    }
</style>