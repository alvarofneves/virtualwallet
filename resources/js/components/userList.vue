<template>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <!-- <th>Type</th>
                <th>Active</th> -->
                <th>NIF</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users" :key="user.id" :class="{active: currentUser === user}">
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <!-- <td>{{ user.type }}</td>
                <td>{{ user.active }}</td> -->
                <td>{{ user.nif }}</td>
                <td v-if="$store.state.user.type=='a'">
                    <a class="btn btn-sm btn-primary" v-on:click.prevent="editUser(user)">Edit</a>
                    <a class="btn btn-sm btn-danger" v-on:click.prevent="deleteUser(user)">Delete</a>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['users','currentUser'],
        data: function () {
            return {
            }
        },
        methods: {
            editUser(user) {
                this.$emit('edit-user',user);
            },
            deleteUser(user) {
                this.$emit('delete-user',user);
            },
            definePlayer(user, playerNumber){
                this.$root['player' + playerNumber];
            }
        }
    }
</script>
<style>

</style>
