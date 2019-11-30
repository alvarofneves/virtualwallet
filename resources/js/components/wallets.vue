<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <wallet-list 
            :wallets="wallets" 
            ref="walletListReference">
        </wallet-list>


        <div class="alert alert-success" v-if="showSuccess">
            <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
            <strong>{{ successMessage }}</strong>
        </div>

        
    </div>
</template>

<script>
    import WalletListComponent from './walletList';


    export default {
        data: function () {
            return {
                title: 'Wallets',
                showSuccess: false,
                showFailure: false,
                successMessage: '',
                failMessage: '',
                wallets: [],
            };
        },
        methods: {
            getWallets: function () {
                axios.get('api/wallets')
                    .then(response => { this.wallets = response.data.data; });
            },
        },
        mounted() {
            this.getWallets();
        },
        components:{
            'wallet-list':WalletListComponent,
        }

    }
</script>

<style>

</style>

