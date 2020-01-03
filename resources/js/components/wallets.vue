<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <wallet-list 
            :wallets="wallets" 
            ref="walletListReference">
        </wallet-list>
    </div>
</template>

<script>
    import WalletListComponent from './walletList';


    export default {
        data: function () {
            return {
                title: 'Wallets',
                wallets: [],
            };
        },
        methods: {
            getWallets: function () {
                axios.get('api/wallets')
                    .then(response => { this.wallets = response.data.data; });
            }
        },
        mounted() {
            this.getWallets();
        },
        components:{
            'wallet-list':WalletListComponent
        }

    }
</script>

<style>

</style>

