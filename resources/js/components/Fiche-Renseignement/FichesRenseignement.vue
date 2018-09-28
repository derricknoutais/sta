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
                    <option :value="marque.id" v-for="marque in marques">{{ marque.nom }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control" v-model="filtre_type" @change="chercheMoteurs()">
                    <option value="type">Sélectionne un Type</option>
                    <option :value="type.id" v-for="type in types">{{ type.nom }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control" v-model="filtre_moteur">
                    <option value="moteur">Sélectionne un Moteur</option>
                    <option :value="moteur.id" v-for="moteur in this.filtered_moteurs">{{ moteur.nom }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control" v-model="filtre_modele">
                    <option value="modèle">Sélectionne un Modèle</option>
                    <option :value="modèle.id" v-for="modèle in this.modèles">{{ modèle.nom }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary" @click="réinitialiser()">Réinitialiser Filtres</button>
            </div>
        </div>
        <div class="row mt-5">
            <div class="card col-md-3 m-1" v-for="fiche in filtered">
                <div class="card-header">
                    <h4 class="text-center">Fiche de Renseignement</h4>
                </div>
                <div class="card-body" >
                    <p><strong>Marque:</strong> {{ fiche.marque.nom }}</p>
                    <p><strong>Type:</strong> {{ fiche.type.nom }}</p>
                    <p><strong>Année:</strong> {{ fiche.année }}</p>
                    <p><strong>Modèle:</strong> {{ fiche.modèle.nom }}</p>
                    <p><strong>Moteur:</strong> {{ fiche.moteur.nom }}</p>
                    <p><strong>Autre details:</strong> {{ fiche.détails }}</p>
                    <p><strong>Articles Recherchés:</strong></p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" v-for="article in fiche.articles">{{ article.nom }}</li>
                    </ul>
                </div> 
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
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
            modèles: []

        }
    },
    methods: {
        chercheTypes(marque){
            console.log(marque)
            axios.get('/fiche-renseignement/type/de-marque/' + marque).then(response => {
                this.types = response.data;
                console.log(response.data);
            }).catch(error => {
                console.log(error);
            });
        },
        chercheMoteurs(){
            axios.get('/fiche-renseignement/moteur/de-type/' + this.filtre_type).then(response => {
                this.moteurs = response.data;
                console.log(response.data);
            }).catch(error => {
                console.log(error);
            });
        },
        chercheModèles(){
            axios.get('/fiche-renseignement/modèle/de-type/' + this.filtre_modèle).then(response => {
                this.modèles = response.data;
                console.log(response.data);
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
        axios.get('fiche-renseignement/api/all').then(response => {
            console.log(response.data);
            this.fiches = this.filtered = response.data
            
        });
        axios.get('fiche-renseignement/marque/api/all').then(response => {
            console.log(response.data);
            this.marques = response.data;
        });
        axios.get('fiche-renseignement/type/api/all').then(response => {
            console.log(response.data);
            this.types = response.data;
        });
        axios.get('fiche-renseignement/moteur/api/all').then(response => {
            console.log(response.data);
            this.filtered_moteurs = this.moteurs.moteurs = response.data;
        });
        axios.get('fiche-renseignement/modèle/api/all').then(response => {
            console.log(response.data);
            this.modèles = response.data;
        });
    }
}
</script>

