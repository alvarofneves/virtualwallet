/*jshint esversion: 6 */

import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: { 
        token: sessionStorage.getItem('token') || null,
        user: {},
        wallet: 0,
        isLogged: false,
        isEdditingProfile: false,
        isCreateMovement: false

       
    },
    mutations: { 
        clearUserAndToken: (state) => {
            state.user = null;
            state.token = "";
            sessionStorage.removeItem('user');
            sessionStorage.removeItem('token');
            axios.defaults.headers.common.Authorization = undefined;
        },
        clearUser: (state) => {
            state.user = null;
            sessionStorage.removeItem('user');
            
        },
        edditingProfileToggle: (state) => {
            if(state.isEdditingProfile == false){
                state.isEdditingProfile = true;
            }else{
                state.isEdditingProfile = false;
            }
        },
        createMovementToggle: (state) => {
            if(state.isCreateMovement == false){
                state.isCreateMovement = true;
            }else{
                state.isCreateMovement = false;
            }
        },
        clearToken: (state) => {
            state.user = null;
            state.wallet = null;
            state.token = "";
            sessionStorage.removeItem('user');
            sessionStorage.removeItem('token');
            sessionStorage.removeItem('wallet');
            axios.defaults.headers.common.Authorization = undefined;
            state.isLogged=false;
        },
        setUser: (state, user) => {
            state.user =  user;
            sessionStorage.setItem('user', JSON.stringify(user));
            state.isLogged=true;
        },
        setWallet: (state, wallet) =>{
            state.wallet = wallet;
            sessionStorage.setItem('wallet', JSON.stringify(wallet));
        },
        setToken: (state, token) => {
            state.token= token;
            sessionStorage.setItem('token', token);
            axios.defaults.headers.common.Authorization = "Bearer " + token;
        },
        loadTokenAndUserFromSession: (state) => {
            state.token = "";
            state.user = null;
            let token = sessionStorage.getItem('token');
            let user = sessionStorage.getItem('user');
            if (token) {
                state.token = token;
                axios.defaults.headers.common.Authorization = "Bearer " + token;
            }else {
                axios.defaults.headers.common.Authorization = undefined;
            }
            if (user) {
                state.user = JSON.parse(user);
                state.isLogged = true;

                if(user.type == "u"){
                    axios.get("api/wallets/" + state.user.id)
                    .then(response => {
                        state.wallet = response.data.data;
                    })
                }
            }
        },
        loadCategories: state => {
            axios.get("api/categories").then(response => {
                state.categories = response.data.data;
            });
        }
    } 
});
