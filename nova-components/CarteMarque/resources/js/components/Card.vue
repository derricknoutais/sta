<template>
    <card class="flex flex-col">
        <div class="card relative metric px-6 py-4 relative card-panel"><!----> 
            <div class="flex mb-4">
                <h3 class="mr-3 text-base text-80 font-bold">Nombre Marques</h3> 
            </div> 
            <p class="flex items-center text-4xl mb-4">11</p> 
            <div class="flex items-center">
                <p class="text-80 font-bold">
                <span>
                    <span></span>
                </span></p>
            </div>
        </div>
    </card>
</template>

<script>
export default {
    props: ['card'],

    mounted() {
        axios.get('/nova-vendor/CarteMarque/all').then(response => {
            console.log(response.data);
            
        }).catch(error => {
            console.log(error);
        });
    },
}
</script>
