<template>
    <div class="jumbotron" align="left">
            <h1 align="center">{{ title }}</h1>
            <div class="inputField">
                <label for="email">Email:</label>
                <input
                    type="email"
                    class="form-control"
                    v-model.trim="email"
                    @change="$v.email.$touch()"
                    placeholder="Email address"
                    id="email"
                    required
                    value
                />
                <p v-if="isSubmitted && !$v.email.required">You must insert an Email</p>
            </div>  
            <br>
            <div class="inputField">
                <label for="password">Password:</label>
                <input
                    type="password"
                    class="form-control"
                    v-model="password"
                    @change="$v.password.$touch()"
                    name="password"
                    id="password"
                    placeholder="Password"
                    required
                    value
                />
                <p v-if="isSubmitted && !$v.password.required">Field Required</p>
            </div>
            <hr />
            <button type="submit" class="btn btn-primary" v-on:click.prevent="userLogin()">
                Login
            </button>
            <button class="btn btn-secondary" v-on:click.prevent="registerUser()"> 
                Register
            </button>
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
            isSubmitted: false
        };
    },
    validations:{
        email: { required, email },
        password: { required }
    },
    methods: {
        userLogin: function(user) {
            this.isSubmitted = true;
            if(!this.$v.$invalid){
                this.editingUser = false;
                axios.post("api/login", {
                        email: this.email,
                        password: this.password
                    })
                    .then(response =>{
                        this.$store.commit("setToken", response.data.access_token);
                        axios.get("api/user")
                        .then(response =>{
                            console.log(response)
                            if(response.data.type == "u"){
                                axios.get("api/wallets/" + response.data.id)
                                .then(response => {
                                    this.$store.commit("setWallet", response.data.data);
                                })
                            }
                            this.$store.commit("setUser", response.data);
                        })
                        .catch(error =>{
                            console.log(error.response.data);
                            console.log("Cannot get user");
                        })
                    })
                    .catch(error =>{
                        console.log(error.response.data);
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
.fail-error{
    width: 100%;
    align-content: left;
    border: 1px solid red;
}

</style>
