<template>
<div class="container">
    <h2 class="text-center mt-5">Bon Commande Nº BC00{{ data.id }}/2018</h2>
    <div class="col-md-3">
        <a href="/commande-achat/nouvelle" class="btn btn-primary">Modifier Commande</a>
    </div>
    <div class="col-md-8 offset-md-2">
        <table class="table table-striped table-inverse mt-5">
            <thead class="thead-inverse"> 
                <tr>
                    <th>Désignation</th>
                    <!-- <th>Quantité</th> -->
                    <th>Coût</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(produit, index) in data.produits">
                    <td scope="row" v-if="produit.variante_deux !== '' && produit.variante_trois !== ''">{{ produit.variante_une + '/' + produit.variante_deux + '/' + produit.variante_trois }}</td>
                    <td scope="row" v-else-if="produit.variante_deux !== ''">{{ produit.variante_une + '/' + produit.variante_deux }}</td>
                    <td scope="row" v-else-if="produit.variante_une !== ''">{{ produit.variante_une }}</td>
                    <td scope="row" v-else>{{ produit.nom }}</td>
                    
                    <!-- <td v-if="produit.pivot.quantité === null"><input :id="'quantité' + index" class="form-control" @keyup="ajouterProduit(index)"/></td>
                    <td v-else>{{ produit.pivot.quantité }}</td> -->
                    
                    <td v-if="produit.pivot.coût === null"><input :id="'coût' + index" class="form-control" @keyup="ajouterProduit(index)"/></td>
                    <td v-else>{{ produit.pivot.coût }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row mt-3">
        <div class="col-md-12 text-center">
            <button class="btn btn-primary" @click="enregistrerCoût()">Enregistrer</button>
        </div>
    </div>
    
</div>
</template>
<script>
export default {
    props: ['data'],
    data(){
        return {
            coûts: [],
            produits: []
        }
    },
    methods:{
        prepareData(){

        },
        ajouterProduit(index){
            var temp = Object.assign({}, {
                // quantité: parseInt(document.getElementById('quantité' + index).value),
                coût: parseInt(document.getElementById('coût' + index).value),
                index: this.data.produits[index].pivot.id
                // total: parseInt(document.getElementById('quantité' + index).value) * parseInt(document.getElementById('coût' + index).value)
            })
            this.produits[index] = temp
        },
        enregistrerCoût(){
            // prepareData();
            axios.post('/demande-achat/api/enregistrer-coût', this.produits ).then(response => {
                console.log(response.data);
            }).catch(error => {
                console.log(error);
            });
        }
    }
}
</script>
