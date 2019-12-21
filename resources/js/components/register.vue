<template>
    <div class="jumbotron" align="left">
        <form class="register" @submit.prevent="register">
            <h1>{{ title }}</h1>
            <label>User name</label>
            <input
                required
                type="text"
                @change="$v.name.$touch()"
                class="form-control"
                v-model.trim="name"
                placeholder="Full name"
                value
            />
            <p v-if="isSubmitted && !$v.name.required">Name required</p>
            <label>Email</label>
            <div class="alert alert-failure" v-if="showFailure">
                <button type="button" class="close-btn" v-on:click="showFailure=false">&times;</button>
                <strong>{{ message }}</strong>
            </div>
            <input
                required
                type="email"
                @change="$v.email.$touch()"
                class="form-control"
                v-model.trim="email"
                placeholder="Email"
                value
            />
            <p v-if="isSubmitted && !$v.email.required">Email required</p>
            <p v-if="isSubmitted && !$v.email.email">Invalid Email</p>
            <label>Password</label>
            <input
                required
                type="password"
                @change="$v.password.$touch()"
                class="form-control"
                v-model="password"
                name="password"
                id="password"
                placeholder="Password"
                value
            />
            <p v-if="isSubmitted && !$v.password.required">Password required</p>
            <p v-if="isSubmitted && !$v.password.minlength">Must have more than 3 characters</p>
            <label>Confirm Password</label>
            <input
                required
                type="password"
                @change="$v.confirmation_password.$touch()"
                class="form-control"
                v-model="confirmation_password"
                name="confirmation_password"
                id="confirmation_password"
                placeholder="Password"
                value
            />
            <p v-if="isSubmitted && !$v.confirmation_password.required">Password confirmation required</p>
            <p v-if="isSubmitted && !$v.confirmation_password.sameAs">Password mismatch</p>
            <label>NIF</label>
            <input
                required
                type="text"
                @change="$v.nif.$touch()"
                class="form-control"
                v-model="nif"
                name="nif"
                id="nif"
                placeholder="NIF"
                value
            />
            <p v-if="isSubmitted && !$v.nif.required">You must insert a NIF</p>
            <p v-if="isSubmitted && !$v.nif.numeric">Can only have numeric characters</p>
            <label>Photo</label>
            <br />
            <input
                type="file"
                class="form-control"
                accept="image/*"
                @change="uploadImage"
            />
            <hr />
            <button class="btn btn-primary" v-on:click.prevent="createUser()">
                Create
            </button>
            <button
                class="btn btn-secondary"
                v-on:click.prevent="cancelRegister()"
            >
                Cancel
            </button>
        </form>
    </div>
</template>
<script>
//TODO: FAZER O BLOQUEIO DO BOTAO CREATE USER SE HOUVER PELO MENOS UM CAMPO OBRIGATORIO POR PREENCHER!
import {
    required,
    email,
    sameAs,
    minLength,
    numeric,
} from "vuelidate/lib/validators";

export default {
    props: ["users"],
    data: function() {
        return {
            title: "Register",
            showFailure: false,
            showSuccess: false,
            message: "",
            name: "",
            email: "",
            password: "",
            confirmation_password: "",
            photo: "",
            nif:"",
            wallet: undefined,
            usersOnRegister: undefined,
            isSubmitted: false
        };
    },
    validations: {
        name: { required },
        email: {
            required,
            email,
        },
        password: {
            required,
            minlength: minLength(3)
        },
        confirmation_password: {
            required,
            sameAs: sameAs("password")
        },
        nif:{
            required,
            numeric
        }
    },
    methods: {
        cancelRegister: function() {
            this.$emit("cancel-register-user");
        },
        createUser: function(user) {
            this.isSubmitted = true;
            axios.get("api/users")
            .then(response => {
                this.usersOnRegister = response.data.data;
                this.showFailure = false;
                this.usersOnRegister.forEach(element => {
                if(this.email == element.email){
                    this.message = "EMAIL JA REGISTADO!";
                    this.showFailure = true;
                }
                });
                if(this.showFailure == false){
                    axios.post("api/users", {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        nif: this.nif,
                        photo: this.photo
                    })
                    .then(response=>{
                        console.log("DEBUG: "+ response.data)
                    })
                      /*  userAboutToLogin = response.data;
                        
                        axios.post("api/wallets", {
                            id: userAboutToLogin.id,
                            email: this.email,
                            balance: 0
                        })
                        .then(response =>{
                            //this.$store.commit("setUser", userAboutToLogin); TODO BETTER CODE!
                        })
                    })*/
                    .catch(error=>{
                        console.log(error.response.data)
                    })

                }
            })
            .catch(error=>{
                console.log(error.response.data)
            })
        },
        uploadImage: function(event){
            var fileReader = new FileReader()

            fileReader.readAsDataURL(event.target.files[0])
            fileReader.onload = (event) =>{
                this.photo = event.target.result
            }
        },
        mounted() {
            console.log(users)
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
p {
    color: red;
}
</style>
