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
            <label>Current Password</label>
            <input
                required
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
                <a class="btn btn-primary" v-on:click.prevent="updateUser()">Save</a>
                <a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
                <label for="teste">DEBUG: {{ user }}</label>
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
                currentPassword: "",
                newPassword: "",
                confirmNewPassword: "",
                isSubmitted: false
            }
        },
        validations: {
                currentPassword: {
                    sameAs: sameAs()
                } 
        },
        methods: {
            updateUser(){
                this.isSubmitted = true;
                //this.$emit('save-user', this.user);
                axios.put("api/users/"+this.user.id, this.user)
                .then(response=>{

                })
                    
                    
            },
            cancelEdit() {
                this.$store.commit("editingProfileToggle");
            }
        }
    }
</script>

<style scoped>

</style>