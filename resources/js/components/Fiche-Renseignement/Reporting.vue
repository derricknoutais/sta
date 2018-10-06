<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <ol class="list-group">
                    <li class="list-group-item" v-for="marque in rang_marque">
                        <span v-if="marque.marque !== null">{{ marque.marque.nom }}</span>
                        <span class="badge badge-pill badge-primary float-right">{{ marque.marque_count }}</span>
                    </li>
                </ol>
            </div>
            <div class="col-md-3">
                <select name="" id="" class="form-control">
                </select>
                <ol class="list-group">
                    <li class="list-group-item" v-for="type in rang_type">
                        <span v-if="type.type !== null">{{ type.type.nom }}</span>
                        <span class="badge badge-pill badge-primary float-right">{{ type.type_count }}</span>
                    </li>
                </ol>
            </div>
            <div class="col-md-3">
                <ol class="list-group">
                    <li class="list-group-item" v-for="moteur in rang_moteur">
                        <span v-if="moteur.moteur !== null">{{ moteur.moteur.nom }}</span>
                        <span class="badge badge-pill badge-primary float-right">{{ moteur.moteur_count }}</span>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['data_moteur', 'data_marque', 'data_type'],
    data(){
        return {
            rang_moteur: '',
            rang_marque: '',
            rang_type: ''
        }
    },
    methods: {
        
    },
    mounted(){
        this.rang_moteur = this.data_moteur;
        this.rang_marque = this.data_marque;
        this.rang_type = this.data_type;
    }
}
</script>
