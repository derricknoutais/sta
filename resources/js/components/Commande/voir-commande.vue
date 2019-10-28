<script>
    export default {
        props: ['data'],
        data(){
            return {
                file: '',
                produits_commande: [],
                articles: [],
                aSupprimer:null
            }
        },
        methods:{
            ajouterProduitASupprimer(produit, index){
                this.aSupprimer = produit
                this.aSupprimer.index = index
            },
            uploadData(){
                this.file = this.$refs.file.files[0];
                let formData = new FormData()
                formData.append('file', this.file)
                formData.append('commande', this.data.id)

                axios.post('/produits-commande/api/upload',formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    console.log(response.data);
                }).catch(error => {
                    console.log(error);
                });
            },
            créerDemandesParFournisseur(){
                axios.get('/demande-achat/api/créerDemandesParFournisseur/' + this.data.id).then(response => {
                    console.log(response.data);

                }).catch(error => {
                    console.log(error);
                });
            },
            créerCommandes(){
                axios.get('/bon-commande/api/créerCommandes/' + this.data.id).then(response => {
                    console.log(response.data);
                    
                }).catch(error => {
                    console.log(error);
                });
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
            axios.get('/produits-commande/api/all/' + this.data.id).then(response => {
                this.produits_commande = response.data;
            }).catch(error => {
                console.log(error);
            });

            axios.get('/article/api/all').then(response => {
                this.articles = response.data
                console.log(response.data);
                
            }).catch(error => {
                console.log(error);
            });
        }
    }
</script>