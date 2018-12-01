
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import vSelect from 'vue-select'

Vue.component('v-select', vSelect)

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('reporting-renseignement', require('./components/Fiche-Renseignement/Reporting.vue'));
Vue.component('fiche-renseignement', require('./components/Fiche-Renseignement/Formulaire.vue'));
Vue.component('fiches-de-renseignement', require('./components/Fiche-Renseignement/FichesRenseignement.vue'));

// NOUVELLE DEMANDE

Vue.component('nouvelle-demande', require('./components/Demande-Achat/nouvelle-demande.vue'));
Vue.component('repertoire-demandes', require('./components/Demande-Achat/répertoire-demandes.vue'));
Vue.component('voir-demande', require('./components/Demande-Achat/voir-demande.vue'));

Vue.component('repertoire-bon-commandes', require('./components/Bon-Commande/répertoire-bon-commandes.vue'));
Vue.component('voir-bon-commande', require('./components/Bon-Commande/voir-bon-commande.vue'));



Vue.component('commande', require('./components/Commande/nouvelle-commande.vue'));
Vue.component('voir-commande', require('./components/Commande/voir-commande.vue'));
Vue.component('repertoire-commandes', require('./components/Commande/répertoire-commandes.vue'));

const app = new Vue({
    el: '#app',
    mounted(){
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
    }
});
