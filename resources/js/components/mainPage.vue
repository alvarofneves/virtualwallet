<template>
    <div class="px-2">
        <div v-if="!this.$store.state.isLogged" align="center">
            <h1>Welcome To VirtualWallets</h1>
            <div>
                <h2>Total Wallets</h2>
                <h1>{{ this.wallets.length }}</h1>
            </div>
            <br /><br />
            <div v-if="!registerUserState">
                <login @begin-register-user="beginRegisterUser" />
            </div>
            <div v-if="registerUserState">
                <register
                    :users="users"
                    @cancel-register-user="cancelRegisterUser"
                />
            </div>
        </div>
        <div v-if="this.$store.state.isLogged">
            <menuNav />
            <div v-if="!this.$store.state.isEdditingProfile">
                <div v-if="!this.$store.state.isCreateMovement">
                    <div v-if="this.$store.state.user.type == 'u'">
                        <movements :users="users" />
                    </div>
                    <div v-if="this.$store.state.user.type == 'o'">
                        <h1> MAN WHAT DA HELL IS THIS! </h1>
                    </div>
                    <div v-if="this.$store.state.user.type == 'a'">
                        <users />
                    </div>
                    
                </div>

                <!-- se  não forem users aparecem a listagem de users -->
                <!-- <div v-if="!this.$store.state.type == 'u'">
                    <users />
                </div> -->

                <div v-if="this.$store.state.isCreateMovement">
                    <movementCreate
                        :categories="this.$store.state.categories"
                    />
                </div>
            </div>
            <div v-if="this.$store.state.isEdditingProfile">
                <profile />
            </div>
        </div>
    </div>
</template>

<script>
import LoginComponent from "./login";
import UsersComponent from "./users";
import ProfileComponent from "./profile";
import RegisterComponent from "./register";
import WalletsComponent from "./wallets";
import MovementsComponent from "./movements";
import MovementCreateComponent from "./movementCreate";
import MenuNavComponent from "./menuNav";

export default {
    //TODO: Tranferir as variaveis boolean da storage para mainPage (meter em variaveis locais)
    props: ["user"],
    data: function() {
        return {
            editingUser: false,
            showWelcome: false,
            successMessage: "",
            failMessage: "",
            currentUser: null,
            users: [],
            movements: [],
            registerUserState: false,
            createMovementState: false,
            wallets: [],
            walletsCount: null
        };
    },
    methods: {
        getUsers: function() {
            axios.get("api/users").then(responseUser => {
                this.users = responseUser.data.data;
                axios.get("api/wallets").then(responseWallets => {
                    this.wallets = responseWallets.data.data;
                    this.users.forEach(user => {
                        this.wallets.forEach(wallet => {
                            if (user.email == wallet.email) {
                                user.wallet = wallet;
                            }
                        });
                    });
                });
            });
        },
        beginRegisterUser: function() {
            this.registerUserState = true;
        },
        cancelRegisterUser: function() {
            this.registerUserState = false;
        },
        beginCreateMovement: function() {
            this.createMovementState = true;
        },
        cancelCreateMovement: function() {
            this.createMovementState = false;
        },
        changeLoginState: function(user) {
            this.$store.commit("setUser", user);
            this.$store.commit("setWallet", user.wallet);
            this.isLogged = true;
        }
    },
    mounted() {
        this.getUsers();
        console.log(this.wallets);
        if (sessionStorage.getItem("token")) {
            this.$store.commit("loadTokenAndUserFromSession");
        }
    },
    computed: {
        isLogged: function() {
            // `this` points to the vm instance
            return this.$store.state.isLogged;
        }
    },
    components: {
        login: LoginComponent,
        users: UsersComponent,
        register: RegisterComponent,
        wallets: WalletsComponent,
        menuNav: MenuNavComponent,
        profile: ProfileComponent,
        movements: MovementsComponent,
        movementCreate: MovementCreateComponent
    }
};
</script>
<style>
.px-2 {
    padding-top: 30px;
}
</style>
