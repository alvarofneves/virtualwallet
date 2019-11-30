<template>
    <div class="jumbotron" align="left">
        <form class="login" @submit.prevent="login">
            <h1 align="center">{{ title }}</h1>
            
            <div class="inputField">
                <label for="email">Email:</label>
                <input
                    type="email"
                    @change="$v.email.$touch()"
                    class="form-control"
                    v-model.trim="email"
                    placeholder="Email address"
                    id="email"
                    required
                    value
                />
                <p v-if="$v.email.$error">You must insert an Email</p>
            </div>  
            <br>
            <div class="inputField">
                <label for="password">Password:</label>
                <input
                    type="password"
                    @change="$v.password.$touch()"
                    class="form-control"
                    v-model="password"
                    name="password"
                    id="password"
                    placeholder="Password"
                    required
                    value
                />
                <p v-if="$v.password.$error">Field Required</p>
            </div>
            <hr />
            <button class="btn btn-primary" v-on:click.prevent="userLogin()">
                Login
            </button>
            <button
                class="btn btn-secondary"
                v-on:click.prevent="registerUser()"
            >
                Register
            </button>
        </form>
    </div>
</template>
<script>
import { required, email } from 'vuelidate/lib/validators';

export default {
    data: function() {
        return {
            title: "Login",
            email: "",
            password: "",
        };
    },
    validations:{
        email: { required, email },
        password: { required }
    },
    methods: {
        userLogin: function(user) {
            if(!this.$v.$invalid){
                this.editingUser = false;
                axios.post("api/login", {
                        email: this.email,
                        password: this.password
                    })
                    .then(response =>{
                        console.log(response);
                        this.$store.commit("setToken", response.data.access_token);
                        axios.get("api/user")
                        .then(response =>{
                            this.$store.commit("setUser", response.data);
                        })
                        .catch(error =>{
                            console.log("Cannot get user");
                        })
                    })
                    .catch(error =>{
                        console.log("Cannot log in");
                    })
            }else{
                console.log("Invalid Credentials");
            }
        },
        registerUser: function() {
            this.$emit("begin-register-user");
        }
    }
};
</script>
<style scoped>
.jumbotron {
    padding-top: 2%;
    padding-bottom: 2%;
    padding-left: 5%;
    padding-right: 5%;
    width: 50%;
}
.form-control {
    width: 100%;
    align-content: left;
}
p{
    color: red;
}
</style>
