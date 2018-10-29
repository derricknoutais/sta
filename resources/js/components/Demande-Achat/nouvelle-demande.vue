<template>
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Créer une demande</h1>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-6 offset-md-3">
            <label>Numéro de la demande</label>
            <input type="text" class="form-control" v-model="numero_selectionne">
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-6 offset-md-3">
            <label>Fournisseur</label>
            <select class="form-control" v-model="fournisseur_selectionne">
                <option :value="fournisseur.id" v-for="fournisseur in fournisseurs">{{ fournisseur.nom }}</option>
            </select>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-6 offset-md-3">
            <label>Commande</label>
            <select class="form-control" v-model="commande_selectionne">
                <option :value="commande.id" v-for="commande in commandes">{{ commande.nom }}</option>
            </select>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12 text-center">
            <button class="btn btn-primary" @click="creerDemande()">Créer</button>
        </div>
    </div>
</div>
    
</template>
<script>
export default {
    data(){
        return {
            fournisseur_selectionne: '',
            numero_selectionne:'',
            commande_selectionne: '',
            fournisseurs: [],
            commandes: []
        }
    },
    methods:{
        creerDemande(){
            axios.post('/demande-achat/api/creer',{fournisseur: this.fournisseur_selectionne, numero: this.numero_selectionne, commande: this.commande_selectionne} ).then(response => {
                console.log(response.data);
                window.location.replace('/demande-achat/répertoire')
            }).catch(error => {
                console.log(error);
            });
        }
    },
    mounted(){
        axios.get('/fournisseur/api/all').then(response => {
            console.log(response.data);
            this.fournisseurs = response.data
        }).catch(error => {
            console.log(error);
        });
        axios.get('/commande/api/all').then(response => {
            this.commandes = response.data;
            
        }).catch(error => {
            console.log(error);
        });
    }
}
</script>
