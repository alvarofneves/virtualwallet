<template>
    <div class="jumbotron">
            <h2>Edit User</h2>
            <div class="form-group">
                <label for="inputName">Name</label>
                <input type="text" class="form-control" v-model="this.user.name"
                       name="name" id="inputName"
                       placeholder="Fullname" value="" />
            </div>
            <div class="form-group">
                <label for="inputEmail">Email</label>
                <input type="email" class="form-control" v-model="this.user.email"
                       name="email" id="inputEmail"
                       placeholder="Email address" value="" />
            </div>
            <div class="form-group">
                <label for="inputAge">Type</label>
                <input type="number" class="form-control" v-model="this.user.type"
                       name="age" id="inputAge"
                       placeholder="Age" value="" />
            </div>
            <div class="form-group">
                <a class="btn btn-primary" v-on:click.prevent="saveUser()">Save</a>
                <a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
            </div>
        </div>
</template>
<script>
    export default {
        data: function () {
            return {
                user: this.$store.state.user
            }
        },
        methods: {
            saveUser(){
                this.$emit('save-user', this.user);
            },
            cancelEdit() {
                this.$store.commit("edditingProfileToggle");
            }
        }
    }
</script>

<style scoped>

</style>