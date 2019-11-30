/*jshint esversion: 6 */

import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: { 
        token: localStorage.getItem('token') || null,
        user: null,
        isLogged: false,
        isEdditingProfile: false,
       
    },
    mutations: { 
        clearUserAndToken: (state) => {
            state.user = null;
            state.token = "";
            localStorage.removeItem('user');
            localStorage.removeItem('token');
            axios.defaults.headers.common.Authorization = undefined;
        },
        clearUser: (state) => {
            state.user = null;
            localStorage.removeItem('user');
            
        },
        edditingProfileToggle: (state) => {
            if(state.isEdditingProfile == false){
                state.isEdditingProfile = true;
            }else{
                state.isEdditingProfile = false;
            }
            
        },
        clearToken: (state) => {
            state.token = "";
            localStorage.removeItem('token');
            axios.defaults.headers.common.Authorization = undefined;
            state.isLogged=false;
        },
        setUser: (state, user) => {
            state.user =  user;
            localStorage.setItem('user', JSON.stringify(user));
            state.isLogged=true;
        },
        setToken: (state, token) => {
            state.token= token;
            localStorage.setItem('token', token);
            axios.defaults.headers.common.Authorization = "Bearer " + token;
        },
        loadTokenAndUserFromSession: (state) => {
            state.token = "";
            state.user = null;
            let token = localStorage.getItem('token');
            let user = localStorage.getItem('user');
            if (token) {
                state.token = token;
                axios.defaults.headers.common.Authorization = "Bearer " + token;
            }
            if (user) {
                state.user = JSON.parse(user);
            }
        },
/*         setMeal: (state, meal) => {
            state.meals.push(meal);
            localStorage.setItem('meals', JSON.stringify(state.meals));
        },
        removeMeal: (state, meal) => {
            state.meals.splice(state.meals.indexOf(meal), 1);
            localStorage.setItem('meals', JSON.stringify(state.meals));
        },
        clearAllMeals: (state) => {
            state.meals = [];
            localStorage.removeItem('meals');
        }, */

    } 
});
