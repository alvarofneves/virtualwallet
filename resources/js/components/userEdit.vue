<template>
    <div class="jumbotron">
        <h2>Edit User</h2>
        <div class="form-group">
            <label for="inputName">Name</label>
            <input
                type="text"
                class="form-control"
                v-model="user.name"
                name="name"
                id="inputName"
                placeholder="Fullname"
                value=""
            />
        </div>
        <div class="form-group">
            <label for="inputEmail">Email</label>
            <input
                type="email"
                class="form-control"
                v-model="user.email"
                name="email"
                id="inputEmail"
                placeholder="Email address"
                value=""
            />
        </div>
        <select v-model="user.type">
            <option v-for="option in options" v-bind:value="option.value" :key="option.id">
                {{ option.text }}
            </option>
        </select>
        <div>
            <b-form-checkbox
                id="ative"
                v-model="user.active"
                name="ative"
                value="1"
                unchecked-value="0"
                >Active
            </b-form-checkbox>
        </div>
        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="saveUser()">Save</a>
            <a class="btn btn-light" v-on:click.prevent="cancelEdit()"
                >Cancel</a
            >
        </div>
    </div>
</template>
<script>
export default {
    props: ["user"],
    data: function() {
        return {
            options: [
                { value: "a", text: "Administrator" },
                { value: "o", text: "Operator" },
                { value: "u", text: "User" }
            ]
        };
    },
    methods: {
        saveUser() {
            console.log(this.user)
            this.$emit("save-user", this.user);
        },
        cancelEdit() {
            this.$emit("cancel-edit");
        }
    }
};
</script>

<style scoped></style>
