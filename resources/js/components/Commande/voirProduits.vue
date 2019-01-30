<template>
    <div class='container'>
        <!-- Header -->
        <div class="row">
            <div class="col">
                <h2 class="text-center">{{ commande.nom }}</h2>
            </div>
        </div>
        <!-- Boutons de Fonctionalité -->
        <div class="row mt-3" @keyup.enter="ajouterProduit()">
            <div class="col-md-6">
                <v-select :options="produits" label="nomComplet" v-model="produit_local_select" ></v-select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-lg btn-primary" @click="ajouterProduit()">Ajouter</button>
            </div>
        </div>
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
                    <td>{{ index + 1 }}</td>
                    <td scope="row">{{ produit.sku }}</td>
                    <td>{{ produit.nom + ' / ' + produit.variante_une + ' / ' + produit.variante_deux + ' / ' + produit.variante_trois }}</td>
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
        </div>
    </div>
</template>

<script>
export default {
    props: ['commande', 'produits'],
    data(){
        return {
            produits_commande: null,
            produits_locaux: null,
            produit_local_select: null,
            aSupprimer:null
        }
    },
    methods:{
        initProduits(){
            this.produits_locaux = this.produits
            this.produits_locaux.forEach( produit => {
                produit.nomComplet = produit.nom + ' / ' + produit.variante_une 
                + ' / ' + produit.variante_deux + ' / ' + produit.variante_trois
            });
        },
        ajouterProduit(){
            axios.post('/commande/' + this.commande.id + '/ajouteProduit',this.produit_local_select ).then(response => {
                this.produits_commande.splice(0,0,this.produit_local_select)
                this.this.produit_local_select = null
                this.$forceUpdate
            }).catch(error => {
                console.log(error);
            });
        },
        ajouterProduitASupprimer(produit, index){
            this.aSupprimer = produit
            this.aSupprimer.index = index
        },
        supprimerProduit(){
            if(this.aSupprimer){
                axios.get('/produits-commande/' + this.aSupprimer.id + '/destroy' ).then(response => {
                    $('#confirmDelete').modal('hide')
                    this.produits_commande.splice((this.aSupprimer.index),1)
                    this.$forceUpdate()
                }).catch(error => { 
                    console.log(error);
                });
            }
        }
    },
    mounted(){
        this.produits_commande = this.commande.produits
        this.initProduits();
    }
}
</script>