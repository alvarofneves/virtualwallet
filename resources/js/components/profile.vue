<template>
    <div class="jumbotron">
        <h2>Edit User</h2>
        <img :src="'/storage/fotos/' + this.$store.state.user.photo">
        <!-- TODO: Atenção, mudar depois do deploy-->
        <label>Email: {{ this.$store.state.user.email }} </label><br /><br />
        <label>Photo</label>
        <br />
        <input
            type="file"
            class="form-control"
            accept="image/*"
            @change="uploadImage"
        />
        <br/><br/>
        <div class="form-group">
            <label for="inputName">Name</label>
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
        <p v-if="isSubmitted && !$v.name.isNameValid">Only letters and spaces acceptable</p>
        <br />
        <label>Current Password</label>
        <input
            type="password"
            @change="$v.currentPassword.$touch()"
            class="form-control"
            v-model="currentPassword"
            name="currentPassword"
            id="currentPassword"
            placeholder="Current Password"
            value
        />
        <p v-if="isSubmitted && !$v.currentPassword.minlength">Must have more than 3 characters</p>
        <label>New password</label>
        <input
            type="password"
            @change="$v.newPassword.$touch()"
            class="form-control"
            v-model="newPassword"
            name="newPassword"
            id="newPassword"
            placeholder="New Password"
        />
        <p v-if="isSubmitted && !$v.newPassword.minlength">Must have more than 3 characters</p>
        <label>Confirm new password</label>
        <input
            type="password"
            @change="$v.confirmNewPassword.$touch()"
            class="form-control"
            v-model="confirmNewPassword"
            name="confirmNewPassword"
            id="confirmNewPassword"
            placeholder="Confirm Password"
        />
        <p v-if="isSubmitted && !$v.confirmNewPassword.minlength">Must have more than 3 characters</p>
        <div class="form-group">
            <label for="inputName">NIF</label>
            <input
                type="text"
                @change="$v.nif.$touch()"
                class="form-control"
                v-model="nif"
                name="nif"
                id="nif"
                placeholder="NIF"
            />
        </div>
        <p v-if="isSubmitted && !$v.nif.nifLength">Must have 9 digits</p>
        <p v-if="isSubmitted && !$v.nif.numeric">Can only have numeric characters</p>
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
    email,
    sameAs,
    numeric,
    minLength,
    maxLength,
    requiredIf,
    helpers
} from "vuelidate/lib/validators";

const isNameValid = helpers.regex("isNameValid", /^[a-zA-Z ]+$/);
const nifLength = helpers.regex("nif", /^[0-9]{9}$/);

export default {
    props: ["users"],
    data: function() {
        return {
            name: this.$store.state.user.name,
            email: "",
            currentPassword: "",
            newPassword: "",
            confirmNewPassword: "",
            nif: this.$store.state.user.nif,
            isSubmitted: false,
            photo: "",
            //updated_at: ""
        };
    },
    validations: {
        name: {
            isNameValid
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
            nifLength,
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
                    this.$store.commit("editingProfileToggle");
                })
                .catch(error => {
                    console.log(error.response.data);
                });
            }else{
                console.log("Invalid Credentials")
            }
        },
        cancelEdit() {
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
