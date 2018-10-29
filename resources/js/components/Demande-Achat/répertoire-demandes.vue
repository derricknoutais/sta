<template>
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <h2 class="text-center">Répertoire de Demandes</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <a href="/demande-achat/nouvelle" class="btn btn-primary">Nouvelle Demande</a>
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
                    <tr v-for="demande in demandes">
                        <td scope="row"><a :href="'/demande-achat/' + demande.id">{{ demande.numéro }}</a></td>
                        <td scope="row">{{ demande.fournisseur.nom }}</td>
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
            demandes: []
        }
    },
    mounted(){
        axios.get('/demande-achat/api/all').then(response => {
            console.log(response.data);
            this.demandes = response.data
        }).catch(error => {
            console.log(error);
        });
    }
}
</script>
