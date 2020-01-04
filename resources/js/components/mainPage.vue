<template>
    <div class="px-2">
        <!-- INDEX -->
        <div v-if="!this.$store.state.isLogged" align="center">
            <h1>Welcome To VirtualWallets</h1>
            <div>
                <h2>Total Wallets</h2>
                <h1>{{ this.wallets.length }}</h1>
            </div>
            <br /><br />
            <div v-if="!registerUserState">
                <!-- Login Page -->
                <login @begin-register-user="beginRegisterUser" />
            </div>
            <div v-if="registerUserState">
                <!-- Register Page -->
                <register
                    :users="this.users"
                    @cancel-register-user="cancelRegisterUser"
                />
            </div>
        </div>
        <!-- LOGGED IN -->
        <div v-if="this.$store.state.isLogged">
            <menuNav />
            <!-- FRONT PAGE -->
            <div v-if="!this.$store.state.isEdditingProfile">
                <!-- USERS -->
                <div v-if="this.$store.state.user.type == 'u'">
                    <!-- Movement List -->
                    <div v-if="!this.$store.state.isCreateMovement">
                        <movements 
                            :users="this.users"
                            :categories="this.categories"
                        />
                    </div>
                    <!-- Movement Create -->
                    <div v-if="this.$store.state.isCreateMovement">
                        <movementCreate
                            :users="this.users"
                            :categories="this.categories"
                        />
                    </div>
                    <!-- Movement Create -->
                    <div v-if="this.$store.state.statistic">
                        <statistic

                        />
                    </div>
                </div>
                <!-- OPERATORS -->
                <div v-if="this.$store.state.user.type == 'o'">
                    <!-- Wallet List -->
                    <div v-if="!this.$store.state.isCreateIncome">
                        <wallets 
                            :users="this.users" 
                            :wallets="this.wallets"
                        />
                    </div>
                    <div v-if="this.$store.state.isCreateIncome">
                        <walletIncome
                            :users="this.users"
                        />
                    </div>
                </div>
                <!-- ADMINS -->
                <div v-if="this.$store.state.user.type == 'a'">
                    <!-- User List -->
                    <div v-if="!this.$store.state.adminIsCreatingAccount">
                        <users 
                            :users="this.users">
                        </users>
                    </div>
                    <div v-if="this.$store.state.adminIsCreatingAccount">
                        <userCreate
                            :users="this.users">
                        </userCreate>
                    </div>
                </div>
            </div>
            <!-- Profile Editing -->
            <div v-if="this.$store.state.isEdditingProfile">
                <profile />
            </div>
        </div>
    </div>
</template>

<script>
    import LoginComponent from "./login";
    import UsersComponent from "./users";
    import UserCreateComponent from "./userCreate";
    import ProfileComponent from "./profile";
    import RegisterComponent from "./register";

    import WalletsComponent from "./wallets";
    import WalletIncomeComponent from './walletIncome';

    import MovementsComponent from "./movements";
    import MovementCreateComponent from "./movementCreate";
    import StatisticsComponent from "./statistics/statistics";
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
                categories: [],
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
                                    if(wallet.email == this.$store.state.user.email){
                                        this.$store.commit("setWallet", wallet);
                                    }
                                    user.wallet = wallet;
                                }
                            });
                        });
                    });
                });
            },
            loadCategories: function() {
                axios.get("api/categories").then(response => {
                    this.categories = response.data.data;
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
        },
        mounted() {
            this.getUsers();
            this.loadCategories();
            if (sessionStorage.getItem("token")) {
                this.$store.commit("loadTokenAndUserFromSession");
            }
            console.log(this.$store.state)
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
            movementCreate: MovementCreateComponent,
            walletIncome: WalletIncomeComponent,
            userCreate: UserCreateComponent,
            statistics: StatisticsComponent
        }
    };
</script>
<style>
.px-2 {
    padding-top: 30px;
}
</style>
