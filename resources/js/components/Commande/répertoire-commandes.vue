<template>
    <div class='container'>
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <h2 class="text-center">Répertoire de Commandes</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <a href="/commande/nouvelle" class="btn btn-primary">Nouvelle Commande</a>
                </div>
            </div>
            <table class="table table-striped table-inverse mt-5">
                <thead class="thead-inverse">
                    <tr>
                        <th>Nom</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="commande in commandes">
                            <td scope="row"><a :href="'/commande/' + commande.id">{{ commande.nom }}</a></td>
                        </tr>
                    </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            commandes: []
        }
    },
    methods:{

    },
    mounted(){
        axios.get('/commande/api/all').then(response => {
            this.commandes = response.data
        }).catch(error => {
            console.log(error);
        });
    }
}
</script>