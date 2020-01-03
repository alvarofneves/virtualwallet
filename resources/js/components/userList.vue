<template>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Wallet</th>
                <th>NIF</th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="user in users"
                :key="user.id"
                :class="{ active: currentUser === user }"
            >
                <td v-if="$store.state.user.id != user.id">{{ user.name }}</td>
                <td v-if="$store.state.user.id != user.id">{{ user.email }}</td>
                <div v-if="$store.state.user.id != user.id">
                    <div v-if="user.type == 'a'">
                        <td>Administator</td>
                    </div>
                    <div v-if="user.type == 'o'">
                        <td>Operator</td>
                    </div>
                    <div v-if="user.type == 'u'">
                        <td>User</td>
                    </div>
                </div>
                <td v-if="$store.state.user.id != user.id && user.type == 'u' && user.wallet.balance > 0"> Has Money </td>
                <td v-if="$store.state.user.id != user.id && user.type == 'u' && user.wallet.balance <= 0"> Empty </td>
                <td v-if="$store.state.user.id != user.id && user.type != 'u'"> --- </td>

                <td v-if="$store.state.user.id != user.id && user.type == 'u'">{{ user.nif }}</td>
                <td v-if="$store.state.user.id != user.id && user.type != 'u'"> --- </td>
                <div v-if="$store.state.user.id != user.id">
                    <td v-if="$store.state.user.type == 'a'">
                        <a
                            class="btn btn-sm btn-primary"
                            v-on:click.prevent="editUser(user)"
                            >Edit</a
                        >
                        <a v-if="user.active == '1'"
                            class="btn btn-sm btn-danger"
                            v-on:click.prevent="toggleActiveUser(user)"
                            >Desativate</a
                        >

                        <a v-if="user.active == '0'"
                            class="btn btn-sm btn-warning"
                            v-on:click.prevent="toggleActiveUser(user)"
                            >Activate</a
                        >
                    </td>
                </div>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: ["users", "currentUser"],
    data: function() {
        return {
        };
    },
    methods: {
        editUser(user) {
            console.log(users)
            this.$emit("edit-user", user);
        },
        toggleActiveUser(user) {
            this.$emit("toggle-active-user", user);
        }
    }
};
</script>
<style></style>
