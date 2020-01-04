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

/* Vue.component('pagination', require('laravel-vue-pagination')); */
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
    created() {
        
    }
    
});
