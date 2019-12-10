<template>
    <div class="jumbotron">
        <pre>{{ $v.oldPassword }}</pre>
            <h2>Edit User</h2>
            <label>Email: {{ this.user.email }} </label><br/><br/>
            <div class="form-group">
                <label for="inputName">Name</label>
                <input type="text" 
                       class="form-control" 
                       v-model="name"
                       name="inputName" id="inputName"
                       placeholder= "New name"  />
            </div>
            <label>Photo</label>
            <br/>
            <input
                type="file"
                accept="image/*"
                @change="uploadImage($event)"
                id="file-input"
            />
            <br/>
            <label>Old Password</label>
            <input
                required
                type="password"
                @change="$v.oldPassword.$touch()"
                class="form-control"
                v-model="oldPassword"
                name="oldPassword"
                id="oldPassword"
                placeholder="Old Password"
                value
            />
            <p v-if="isSubmitted && !$v.oldPassword.minlength">Must have more than 3 characters</p>
            <label>New password</label>
            <input
                required
                type="password"
                @change="$v.password.$touch()"
                class="form-control"
                v-model="newPassword"
                name="newPassword"
                id="newPassword"
                placeholder="New Password"
            />
            <label>Confirm new password</label>
            <input
                required
                type="password"
                @change="$v.confirmNewPassword.$touch()"
                class="form-control"
                v-model="confirmNewPassword"
                name="confirmNewPassword"
                id="confirmNewPassword"
                placeholder="Confirm Password"
            />
            <div class="form-group">
                <a class="btn btn-primary" v-on:click.prevent="saveUser()">Save</a>
                <a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
                <label for="teste">{{ user }}</label>
            </div>
        </div>
</template>
<script>
import {
    alpha,
    email,
    sameAs,
    minLength,
    numeric,
} from "vuelidate/lib/validators";

    export default {
        //props: ['user'],
        data: function () {
            return {
                user: this.$store.state.user,
                name: "",
                oldPassword: "",
                newPassword: "",
                confirmNewPassword: "",
                isSubmitted: false
            }
        },
        validations: {
                oldPassword: {
                    sameAs: sameAs()
                } 
        },
        methods: {
            saveUser(){
                this.isSubmitted = true;
                this.$emit('save-user', this.user);
            },
            cancelEdit() {
                this.$store.commit("editingProfileToggle");
            }
        }
    }
</script>

<style scoped>

</style>