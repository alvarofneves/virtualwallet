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
import Users from './components/users';
import Login from './components/login';
import Register from './components/register';
import MainPage from './components/mainPage';
import Wallets from './components/wallets';
import Movements from './components/movements';
import BootstrapVue from 'bootstrap-vue';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

window.Vue = require('vue');

Vue.use(Vuelidate)
Vue.use(VueRouter)
Vue.use(BootstrapVue)

const routes = [
    {path:'/', redirect:'/mainPage'},
    {path:'/users', component:Users},
    {path:'/wallets', component:Wallets},
    {path:'/login', component:Login},
    {path:'/register', component:Register},
    {path:'/mainPage', component:MainPage},
    {path:'/movements', component:Movements}
]

const router = new VueRouter({
    routes
})

const app = new Vue({
    el: '#app',
    store,
    router,
    data: {
        
    },
    methods: {
        
    },
    mounted() {

    }
    
});
