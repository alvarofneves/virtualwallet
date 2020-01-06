/*jshint esversion: 6 */

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import store from './store/auth';
import Vuelidate from 'vuelidate';
import VueRouter from 'vue-router';
import MainPage from './components/mainPage';
import BootstrapVue from 'bootstrap-vue';
import StackModal from '@innologica/vue-stackable-modal';
import VueApexCharts from 'vue-apexcharts'

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

window.Vue = require('vue');

import VueSocketIO from "vue-socket.io";

Vue.use(
    new VueSocketIO({
        debug: true,
        connection: "http://127.0.0.1:8080"
    })
);

import Toasted from "vue-toasted";
Vue.use(Toasted, {
    position: "bottom-center",
    duration: 5000,
    type: "info"
});

Vue.use(Vuelidate)
Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.use(StackModal)
Vue.use(VueApexCharts)

const routes = [
    {path:'/', redirect:'/mainPage'},
    {path:'/mainPage', component:MainPage}
]

const router = new VueRouter({
    routes
})

const app = new Vue({
    el: '#app',
    store,
    router,
    sockets: {
        connect(){
            console.log(this.$socket.id);
        },
        create_movement(movement) {  
            if(movement.data.id === this.$store.state.user.id){
                console.log('----------------here--------------------');
                console.log(movement);

                this.$store.commit("addValueToWallet", parseFloat(movement.data.balance));

                this.$toasted.show(
                    'Recebeste o valor ' + movement.data.balance + ' na tua virtual wallet!!!'
                ,{
                    theme: "outline", 
                    position: "top-right", 
                    duration : 5000
                });
            }

        },
        
        
    },
    created() {
        
    }
    
});
