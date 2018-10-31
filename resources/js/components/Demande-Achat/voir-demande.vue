<template>
<div class="container">
    <h2 class="text-center mt-5">Demande Achat Nº {{ data.numéro }} ( {{ data.fournisseur.nom }})</h2>
    <div class="row">
        <div class="col-md-3">
            <button class="btn btn-primary" @click="activeModification">Modifier Demande</button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4">
            <v-select :options="produitsEnregistrés" label="nom"></v-select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-inverse mt-5">
                <thead class="thead-inverse">
                    <tr>
                        <th>Index</th>
                        <th>Désignation</th>
                        <th>Quantité</th>
                        <th>Coût</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(produit, index) in data.produits">
                        <td>{{ index + 1}}</td>
                        <td scope="row" v-if="produit.variante_deux !== '' && produit.variante_trois !== ''">{{ produit.variante_une + '/' + produit.variante_deux + '/' + produit.variante_trois }}</td>
                        <td scope="row" v-else-if="produit.variante_deux !== ''">{{ produit.variante_une + '/' + produit.variante_deux }}</td>
                        <td scope="row" v-else-if="produit.variante_une !== ''">{{ produit.variante_une }}</td>
                        <td scope="row" v-else>{{ produit.nom }}</td>

                        <td v-if="produit.pivot.quantité === null"><input :id="'quantité' + index" class="form-control" @keyup="ajouterQuantité(index)"/></td>
                        <td v-else-if="editing"><input :id="'quantité' + index" class="form-control" @keyup="ajouterQuantité(index)" :value="produit.pivot.quantité"/></td>
                        <td v-else :id="'quantité' + index">{{ produit.pivot.quantité }}</td>

                        <td v-if="produit.pivot.coût === null"><input :id="'coût' + index" class="form-control" @keyup="ajouterCoût(index)"/></td>
                        <td v-else-if="editing"><input :id="'coût' + index" class="form-control" @keyup="ajouterCoût(index)" :value="produit.pivot.coût"/></td>
                        <td v-else>{{ produit.pivot.coût }}</td>

                        <td :id="'total' + index" v-if="editing || produit.pivot.total === null"></td>
                        <td v-else>{{ produit.pivot.total }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-right">Montant Total</td>
                        <td id="montantTotal"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="row mt-3">
        <div class="col-md-12 text-center">
            <button class="btn btn-primary" @click="enregistrerQuantité()">Enregistrer Demande</button>
        </div>
    </div>
    
</div>
</template>
<script>
export default {
    props: ['data'],
    data(){
        return {
            editing: false,
            coûts: [],
            produits: [],
            quantitéAEnregistrer : false,
            produitsEnregistrés: []
        }
    },
    methods:{
        activeModification(){
            this.editing = true;
            
        },
        ajouterQuantité(index){
            if(this.data.produits[index].pivot.quantité === null || this.editing){
                var quantité = parseInt(document.getElementById('quantité' + index).value);
                if(! isNaN(quantité) ){
                    var found = false;
                    this.produits.forEach(element => {
                        if( element.id === this.data.produits[index].pivot.id ){
                            element.quantité = quantité;
                            found = true
                        }
                    });
                    if(! found){
                        var temp = Object.assign({}, {
                            'quantité': quantité,
                            'id': this.data.produits[index].pivot.id
                        });
                        Vue.set(this.produits, index, temp)
                    }
                } else {
                    this.produits.forEach(element => {
                        if( element.id === this.data.produits[index].pivot.id ){
                            element.quantité = null;
                            found = true
                        }
                    });
                }
            }
        },
        ajouterCoût(index){
            if(this.data.produits[index].pivot.coût === null || this.editing){
                var coût = parseInt(document.getElementById('coût' + index).value);
                if(! isNaN(coût)){
                    var found = false;
                    this.produits.forEach(element => {
                        if( element.id === this.data.produits[index].pivot.id ){
                            element.coût = coût;
                            found = true
                        }
                    });
                    if(! found){
                        var temp = Object.assign({}, {
                            'coût': coût,
                            'id': this.data.produits[index].pivot.id
                        });
                        Vue.set(this.produits, index, temp)
                    }
                }

            } else {
                this.produits.forEach(element => {
                    if( element.id === this.data.produits[index].pivot.id ){
                        element.coût = null;
                        found = true
                    }
                });
            }
        },
        enregistrerQuantité(){
            axios.post('/demande-achat/api/ajouter-quantité', this.produits).then(response => {
                console.log(response.data);
            }).catch(error => {
                console.log(error);
            });
        },
        ajouterProduit(index){
            // console.log(document.getElementById('coût' + index).value)
            // // if(document.getElementById('coût' + index).value === ''){
            // //     document.getElementById('coût' + index).innerHTML = 0;
            // // }
            // // console.log(parseInt(document.getElementById('quantité' + index).value) * parseInt(document.getElementById('coût' + index).value));
            // document.getElementById('total' + index).innerHTML =  parseInt(document.getElementById('quantité' + index).value) * parseInt(document.getElementById('coût' + index).value);
            // var temp = Object.assign({}, {
            //     quantité: parseInt(document.getElementById('quantité' + index).value),
            //     coût: parseInt(document.getElementById('coût' + index).value),
            //     index: this.data.produits[index].pivot.id,
            //     total: parseInt(document.getElementById('quantité' + index).value) * parseInt(document.getElementById('coût' + index).value)
            // });
            
            // this.produits[index] = temp
            // var montantTotal = 0;
            // this.produits.forEach( (element, idx) => {
            //     montantTotal += this.produits[idx].total

            // });
            // console.log(montantTotal);
            // document.getElementById('montantTotal').innerHTML = montantTotal;
        },
        enregistrerCoût(){
            // prepareData();
            axios.post('/demande-achat/api/enregistrer-coût', this.produits ).then(response => {
                console.log(response.data);
            }).catch(error => {
                console.log(error);
            });
        }
    },
    mounted(){
        var montantTotal = 0;
        this.data.produits.forEach( (element, index) => {
            montantTotal += parseInt(element.pivot.quantité * element.pivot.coût);
        });
        document.getElementById('montantTotal').innerHTML = montantTotal;

        axios.get('/produits/api/all').then(response => {
            this.produitsEnregistrés = response.data;
            this.produitsEnregistrés.forEach(element => {
                element.nom = element.nom + " --" + element.variante_une + element.variante_deux + element.variante_trois
            })
        }).catch(error => {
            console.log(error);
        });
    }
}
</script>
