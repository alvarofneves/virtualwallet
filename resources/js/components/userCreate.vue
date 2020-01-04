<template>
    <div class="jumbotron">
        <h2>User Create</h2>
        <!-- TODO: Atenção, mudar depois do deploy-->
        <div class="form-group">
            <label for="typeOfUser">Type of User:</label>
            <select
                class="form-control"
                id="typeOfUser"
                name="typeOfUser"
                v-model="typeOfUser"
            >
                <option value="o"> Operator </option>
                <option value="a"> Administrator </option>
            </select>
        </div>
        <label>Email:</label>
        <input
            type="email"
            @change="$v.email.$touch()"
            class="form-control"
            v-model="email"
            name="email"
            id="email"
            placeholder="Email"
        />
        <div class="alert alert-failure" v-if="showFailure">
                <button type="button" class="close-btn" v-on:click="showFailure=false">&times;</button>
                <p>{{ message }}</p>
        </div>
        <p v-if="isSubmitted && !$v.email.required">Email required</p>
        <p v-if="isSubmitted && !$v.email.email">Invalid Email</p>
        <label>Photo:</label>
        <input
            type="file"
            class="form-control"
            accept="image/*"
            @change="uploadImage"
        />
        <div class="form-group">
            <label for="inputName">Name:</label>
            <input
                type="text"
                @change="$v.name.$touch()"
                class="form-control"
                v-model="name"
                name="name"
                id="name"
                placeholder="Name"
            />
        </div>
        <p v-if="isSubmitted && !$v.name.required">Account name required!</p>
        <p v-if="isSubmitted && !$v.name.isNameValid">
            Account name must contain letters and spaces only!
        </p>
        <label>Password:</label>
        <input
            type="password"
            @change="$v.password.$touch()"
            class="form-control"
            v-model="password"
            name="password"
            id="password"
            placeholder="Password"
        />
        <p v-if="isSubmitted && !$v.password.minlength">
            Must have more than 3 characters
        </p>
        <label>Confirm password:</label>
        <input
            type="password"
            @change="$v.confirmPassword.$touch()"
            class="form-control"
            v-model="confirmPassword"
            name="confirmPassword"
            id="confirmPassword"
            placeholder="Confirm Password"
        />
        <p v-if="isSubmitted && !$v.confirmPassword.minlength">
            Must have more than 3 characters
        </p>
        <p v-if="isSubmitted && !$v.confirmPassword.sameAs">
            Password doesn't match!
        </p>
        <br />
        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="createUser()"
                >Save</a
            >
            <a class="btn btn-light" v-on:click.prevent="cancelCreate()"
                >Cancel</a
            >
        </div>
    </div>
</template>
<script>
import {
    alpha,
    email,
    sameAs,
    minLength,
    helpers,
    required
} from "vuelidate/lib/validators";

const isNameValid = helpers.regex("isNameValid", /^[a-zA-Z ]+$/);

export default {
    props: ["users"],
    data: function() {
        return {
            name: "",
            email: "",
            password: "",
            confirmPassword: "",
            isSubmitted: false,
            photo: "",
            typeOfUser: "o",
            usersOnRegister: [],
            message: "",
            showFailure: false,
            showSuccess: false
        };
    },
    validations: {
        email:{
            required,
            email
        },
        name: {
            isNameValid,
            required
        },
        password: {
            minlength: minLength(3)
        },
        confirmPassword: {
            minlength: minLength(3),
            sameAs: sameAs("password")
        }
    },
    methods: {
        createUser() {

            if(this.photo != null){
                axios.get("api/users")
                .then(response => {
                    this.usersOnRegister = response.data.data;
                    this.showFailure = false;
                    this.usersOnRegister.forEach(element => {
                    if(this.email == element.email){
                        this.message = "This Email is already registered!";
                        this.showFailure = true;
                    }
                    });
                    if(this.showFailure == false){
                        axios.post("api/users", {
                            name: this.name,
                            email: this.email,
                            password: this.password,
                            photo: this.photo,
                            type: this.typeOfUser
                        })
                        .then(response => {
                            console.log(response.data.data)
                        })
                    }
                })
            }else{
                
            }
        },
        cancelCreate() {
            console.log(this.$store.state.user.photo)
            this.$store.commit("editingProfileToggle");
        },
        uploadImage: function(event){
            var fileReader = new FileReader()

            fileReader.readAsDataURL(event.target.files[0])
            fileReader.onload = (event) =>{
                this.photo = event.target.result
            }
        }
    }
};
</script>

<style scoped>
p {
    color: red;
}
img {
    width: 128px;
}
</style>
