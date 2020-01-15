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
import Axios from 'axios';
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
            console.log("aqui")
            console.log(movement)

            if(movement.wallet_id === this.$store.state.wallet.id){
                this.$store.commit("addValueToWallet", movement.value);

                this.$toasted.show(
                    'Recebeste o valor ' + movement.value + ' na tua virtual wallet!!!'
                ,{
                    theme: "outline", 
                    position: "top-right", 
                    duration : 10000
                });
            }

            if(movement.wallet_id == 11 && this.$store.state.wallet.id != movement.wallet_id){
                this.$toasted.show(
                    'O User 12 Recebeu: ' + movement.value + ' na virtual wallet!!!'
                ,{
                    theme: "outline", 
                    position: "top-right", 
                    duration : 10000
                });
            }

            if(movement.wallet_id == 12 && this.$store.state.wallet.id != movement.wallet_id){
                this.$toasted.show(
                    'O User 11 Recebeu: ' + movement.value + ' na virtual wallet!!!'
                ,{
                    theme: "outline", 
                    position: "top-right", 
                    duration : 10000
                });
            }

            if(movement.value >= 1000 && this.$store.state.user.type == 'a'){
                axios.get("api/users/" + movement.wallet_id)
                .then(response => {
                    let userOrigem = response.data.data;
                    console.log(userOrigem)
                    axios.get("api/users/" + movement.transfer_wallet_id)
                    .then(response => {
                        this.$toasted.show(
                            'O User: ' + userOrigem.name + ', Recebeu:' + movement.value + '€ do User:' + response.data.data.name
                        ,{
                            theme: "outline", 
                            position: "top-right", 
                            duration : 10000
                        });
                    })
                });
            }

        },
        /* verify_movement(movement) {  
            if(this.$store.state.user.type=='a'){
                console.log('passo 2');
                
                this.$toasted.show(
                    'O user ' + movement.data.email  + ' recebeu ' + movement.data.balance +' !!'
                ,{
                    theme: "outline", 
                    position: "top-right", 
                    duration : 10000
                });
            }

        }, */
        user_account_status(user){
            if(this.$store.state.user.type =='a')
                if(user.active==0){
                    this.$toasted.show(
                        user.name + ' foi desativado!!'
                    ,{
                        theme: "outline", 
                        position: "top-right", 
                        duration : 5000
                    });
                }
                else{
                    this.$toasted.show(
                        user.name + ' foi ativado!!'
                    ,{
                        theme: "outline", 
                        position: "top-right", 
                        duration : 5000
                    });
                }
            

        }
        
        
    },
    created() {
        
    }
    
});
