<template>
    <div class="jumbotron">
        <h2>User Create</h2>
        <!-- TODO: Atenção, mudar depois do deploy-->
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
        <p v-if="isSubmitted && !$v.name.alpha">Only letters acceptable</p>
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
        <p v-if="isSubmitted && !$v.newPassword.minlength">Must have more than 3 characters</p>
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
        <p v-if="isSubmitted && !$v.confirmNewPassword.minlength">Must have more than 3 characters</p>
        <div class="form-group">
            <label for="typeOfUser">Type of User:</label>
            <select class="form-control" 
                    id="typeOfUser" 
                    name="typeOfUser" 
                    v-model="typeOfUser">
	            <option value="o"> Operator </option>
                <option value="a"> Administrator </option>
	        </select>
        </div>
        <br />
        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="updateUser()"
                >Save</a
            >
            <a class="btn btn-light" v-on:click.prevent="cancelEdit()"
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
    numeric,
    minLength,
    maxLength,
    requiredIf
} from "vuelidate/lib/validators";

export default {
    props: ["users"],
    data: function() {
        return {
            name: "",
            email: "",
            password: "",
            confirmPassword: "",
            nif: "",
            isSubmitted: false,
            photo: "",
            typeOfUser: "o"
        };
    },
    validations: {
        name: {
            alpha: alpha
        },
        currentPassword:{
            minlength: minLength(3)
        },
        newPassword: {
            minlength: minLength(3)
        },
        confirmNewPassword: {
            minlength: minLength(3),
            sameAs: sameAs("newPassword")
        },
        nif:{
            minLength: minLength(8),
            maxlength: maxLength(10),
            numeric
        },
    },
    methods: {
        updateUser() {
            this.isSubmitted = true;
            //this.$emit('save-user', this.user);
            if(!this.$v.$invalid){
                this.editingUser = false;
            axios
                .put("api/users/" + this.$store.state.user.id, {
                    name: this.name,
                    email: this.$store.state.user.email,
                    currentPassword: this.currentPassword,
                    password: this.newPassword,
                    nif: this.nif,
                    photo: this.photo,
                    //updated_at: Date.now
                })
                .then(response => {
                    console.log(response.data);
                    this.$store.commit("setUser", response.data.data);
                })
                .catch(error => {
                    console.log(error.response.data);
                });
            }else{
                console.log("Invalid Credentials")
            }
        },
        cancelEdit() {
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
img{
    width: 128px
}
</style>
