<template>
    <div class="jumbotron">
        <pre>{{ $v.nif }}</pre>
        <h2>Edit User</h2>
        <label>Email: {{ this.$store.state.user.email }} </label><br /><br />
        <div class="form-group">
            <label for="inputName">Name</label>
            <input
                type="text"
                @change="$v.name.$touch()"
                class="form-control"
                v-model="name"
                name="name"
                id="name"
                placeholder="New name"
            />
        </div>
        <p v-if="isSubmitted && !$v.name.alpha">Only letters acceptable</p>
        <label>Photo</label>
        <br />
        <input
            type="file"
            accept="image/*"
            @change="uploadImage($event)"
            id="file-input"
        />
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
        <p v-if="isSubmitted && $v.currentPassword.minlength">Must have more than 3 characters</p>
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
        <p v-if="isSubmitted && !$v.nif.minlength">Must have 9 digits</p>
        <p v-if="isSubmitted && !$v.nif.maxlength">Must have 9 digits</p>
        <p v-if="isSubmitted && !$v.nif.numeric">Can only have numeric characters</p>
        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="updateUser()"
                >Save</a
            >
            <a class="btn btn-light" v-on:click.prevent="cancelEdit()"
                >Cancel</a
            >
            <label for="teste">DEBUG: {{ this.$store.state.user }}</label>
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
    props: ["user"],
    data: function() {
        return {
            name: "",
            email: "",
            currentPassword: "",
            newPassword: "",
            confirmNewPassword: "",
            nif: "",
            isSubmitted: false
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
            minLength: minLength(9),
            maxlength: maxLength(9),
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
                    nif: this.nif
                })
                .then(response => {
                    console.log(response.data);
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
        }
    }
};
</script>

<style scoped>
p {
    color: red;
}
</style>
