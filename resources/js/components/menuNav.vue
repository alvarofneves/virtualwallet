<template>
        <nav class="navbar navbar-expand navbar-dark bg-dark fixed-top">

        <a class="navbar-brand mr-1" >
            <h1 style="color:white;">
                <img v-on:click.prevent="profile()" height="60" width="60" :src="'/storage/fotos/' + this.$store.state.user.photo">
                Welcome, {{ this.$store.state.user.name }}
            </h1>
        </a>

        <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
        </button>

        <!-- Navbar Search -->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div v-if="this.$store.state.isEdditingProfile == false" class="input-group">
            <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
            <button v-on:click.prevent="" class="btn btn-primary" type="button">
                <i class="fas fa-search"></i>
            </button>
            </div>
        </div>
        </form>

        <!-- Navbar -->
        <ul class="navbar-nav ml-auto ml-md-0">
        <b-navbar-nav v-if="this.$store.state.isEdditingProfile == false && this.$store.state.user.type == 'a'">
            <b-nav-item-dropdown text="Modifications" right>
                <b-dropdown-item v-if="!this.$store.state.adminIsCreatingAccount" v-on:click.prevent="adminIsCreatingAccount()">Create Account</b-dropdown-item>
                <b-dropdown-item v-if="this.$store.state.adminIsCreatingAccount" v-on:click.prevent="adminIsCreatingAccount()">Users List</b-dropdown-item>
                <b-dropdown-item  v-if="this.$store.state.user.type != 'o'" v-on:click.prevent="statistics()">Statistics</b-dropdown-item>
            </b-nav-item-dropdown>
        </b-navbar-nav>
        <b-navbar-nav v-if="this.$store.state.isEdditingProfile == false && this.$store.state.user.type != 'a'">
            <b-nav-item-dropdown text="Movements" right>
                <b-dropdown-item v-if="this.$store.state.isCreateMovement == false && this.$store.state.user.type == 'u'" v-on:click.prevent="createMovement()">Create Movement</b-dropdown-item>
                <b-dropdown-item v-if="this.$store.state.user.type == 'u' && this.$store.state.isCreateMovement == true" v-on:click.prevent="createMovement()">Movements</b-dropdown-item>
                <b-dropdown-item v-if="this.$store.state.isCreateIncome == false && this.$store.state.user.type == 'o'" v-on:click.prevent="createIncome()">Create Income</b-dropdown-item>
                <b-dropdown-item v-if="this.$store.state.user.type == 'o' && this.$store.state.isCreateIncome == true" v-on:click.prevent="createIncome()">Wallets</b-dropdown-item>
                
                <b-dropdown-item  v-if="this.$store.state.user.type != 'o'" v-on:click.prevent="statistics()">Statistics</b-dropdown-item>
            </b-nav-item-dropdown>
        </b-navbar-nav>
        <b-navbar-nav v-if="this.$store.state.isEdditingProfile == false && this.$store.state.user.type == 'u'">
            <b-nav-item-dropdown text="Notifications" right>
                <b-dropdown-item v-on:click.prevent="">Movements</b-dropdown-item>
            </b-nav-item-dropdown>
        </b-navbar-nav>
        <b-navbar-nav v-if="this.$store.state.isEdditingProfile == true" v-on:click.prevent="profile()">
            <b-nav-item right>
                &lt&lt
            </b-nav-item>
        </b-navbar-nav>
        <b-navbar-nav>
            <b-nav-item-dropdown text="Account" right>
                <b-dropdown-item v-if="this.$store.state.isEdditingProfile == false" v-on:click.prevent="profile()">Profile</b-dropdown-item>
                <b-dropdown-item v-if="this.$store.state.isEdditingProfile == true && this.$store.state.user.type == 'u'" v-on:click.prevent="profile()">Movements</b-dropdown-item>
                <b-dropdown-item v-if="this.$store.state.isEdditingProfile == true && this.$store.state.user.type == 'o'" v-on:click.prevent="profile()">Wallets</b-dropdown-item>
                <b-dropdown-item v-if="this.$store.state.isEdditingProfile == true && this.$store.state.user.type == 'a'" v-on:click.prevent="profile()">Users</b-dropdown-item>
                <b-dropdown-item v-on:click.prevent="logout()">Logout</b-dropdown-item>
            </b-nav-item-dropdown>
        </b-navbar-nav>
        </ul>
    </nav>
</template>

<script>
export default {
    
    props: ['users','wallets'],
    methods: {
        profile: function(){
            console.log(this.$store.state.user);
            this.$store.commit("editingProfileToggle");
        },
        createMovement: function(){
            this.$store.commit("createMovementToggle");
        },
        createIncome: function(){
            this.$store.commit("createIncomeToggle");
        },
        statistics: function(){
            this.$store.commit("statisticsToggle");
        },
        adminIsCreatingAccount: function(){
            this.$store.commit("adminIsCreatingAccountToggle");
        },
        logout: function(){
            axios.post("api/logout", this.$store.state.user
            )
            .then(response =>{
                console.log("Logout Success (DEBUG): ");
                console.log(response);
                this.$store.commit("clearToken");
            })
            .catch(error =>{
                console.log("Cannot logout " + error);
            })
        }
    }

}
</script>