<template>
    <div class='container'>
        <div class="col-md-8 offset-md-2">
            <div class="form-group">
              <label for="">Nom</label>
              <input type="text" class="form-control" v-model="nom">
            </div>
            <div class="form-group text-center">
              <button class="btn btn-primary" @click="créerCommande()">Créer</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            nom: ''
        }
    },
    methods:{
        créerCommande(){
            axios.post('/commande/api/nouvelle',{ nom: this.nom }).then(response => {
                window.location.href = '/commande/répertoire';
            }).catch(error => {
                console.log(error);
            });
        }
    },
    mounted(){

    }
}
</script>