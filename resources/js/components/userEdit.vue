<template>
    <div class="jumbotron">
            <h2>Edit User</h2>
            <div class="form-group">
                <label for="inputName">Name</label>
                <input type="text" class="form-control" v-model="user.name"
                       name="name" id="inputName"
                       placeholder="Fullname" value="" />
            </div>
            <div class="form-group">
                <label for="inputEmail">Email</label>
                <input type="email" class="form-control" v-model="user.email"
                       name="email" id="inputEmail"
                       placeholder="Email address" value="" />
            </div>
            <div class="form-group">
                <label for="inputAge">Type</label>
                <input type="number" class="form-control" v-model="user.type"
                       name="age" id="inputType"
                       placeholder="Type" value="" />
            </div>
            <!-- <div class="form-group">
                <label for="department_id">Department:</label>
                <select class="form-control" id="department_id" name="department_id" v-model="user.department_id">
                    <option v-for="department in departments" :key="department.id" v-bind:value="department.id"> {{ department.name }} </option>
                </select>
            </div> -->

            <div class="form-group">
                <a class="btn btn-primary" v-on:click.prevent="saveUser()">Save</a>
                <a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
            </div>
        </div>
</template>
<script>
    export default {
        props: ['user'],
        data: function () {
            return {}
        },
        methods: {
            saveUser(){
                this.$emit('save-user', this.user);
            },
            cancelEdit() {
                this.$emit('cancel-edit');
            }
        }
    }
</script>

<style scoped>

</style>