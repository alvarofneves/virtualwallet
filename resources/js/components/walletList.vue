<template>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Wallet's ID</th>
                <th>User's Email</th>
                <th>Wallet Created At</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="wallet in wallets" :key="wallet.id">
                <td>{{ wallet.id }}</td>
                <td>{{ wallet.email }}</td>
                <td>{{wallet.created_at.substring(0,10) + " | " + wallet.created_at.substring(11,19)}}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['wallets'],
        data: function () {
            return {
            }
        },
        methods: {
            addIncome: function(wallet){
                this.$emit("wallet-income", wallet);
            }
        }
    }
</script>
<style>

</style>
