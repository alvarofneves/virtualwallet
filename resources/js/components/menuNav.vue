<template>
        <nav class="navbar navbar-expand navbar-dark bg-dark fixed-top">

        <a class="navbar-brand mr-1" href="index.html">
            <h1>Welcome, {{ this.$store.state.user.name }}</h1>
        </a>

        <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
        </button>

        <!-- Navbar Search -->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
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
        <b-navbar-nav>
            <b-nav-item-dropdown text="Notifications" right>
                <b-dropdown-item v-on:click.prevent="">Movements</b-dropdown-item>
                <b-dropdown-item v-on:click.prevent="">Statistics</b-dropdown-item>
            </b-nav-item-dropdown>
        </b-navbar-nav>
        <b-navbar-nav>
            <b-nav-item-dropdown text="User" right>

                <b-dropdown-item v-if="this.$store.state.isEdditingProfile == false" v-on:click.prevent="profile()">Profile</b-dropdown-item>
                <b-dropdown-item v-if="this.$store.state.isEdditingProfile == true" v-on:click.prevent="profile()">Wallets</b-dropdown-item>
                <b-dropdown-item v-on:click.prevent="logout()">Logout</b-dropdown-item>
            </b-nav-item-dropdown>
        </b-navbar-nav>
        </ul>
    </nav>
</template>

<script>
export default {
    
    props: ['wallets'],
    methods: {
        profile: function(){
            this.$store.commit("edditingProfileToggle");
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