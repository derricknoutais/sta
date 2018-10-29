
<template>
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <h2 class="text-center">Répertoire de Bons commandes</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <a href="/commande-achat/nouvelle" class="btn btn-primary">Nouvelle commande</a>
            </div>
        </div>
        <table class="table table-striped table-inverse mt-5">
            <thead class="thead-inverse">
                <tr>
                    <th>Numéro</th>
                    <th>Fournisseur</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="commande in commandes">
                        <td scope="row"><a :href="'/bon-commande/' + commande.id">BC00{{ commande.id }}</a></td>
                        <td scope="row">{{ commande.fournisseur.nom }}</td>
                        <td></td>
                    </tr>
                </tbody>
        </table>
    </div>
</template>
<script>
export default {
    data(){
        return {
            commandes: []
        }
    },
    mounted(){
        axios.get('/bon-commande/api/all').then(response => {
            this.commandes = response.data
        }).catch(error => {
            console.log(error);
        });
    }
}
</script>
