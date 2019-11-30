<template>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Email</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="wallet in wallets" :key="wallet.id">
                <td>{{ wallet.email }}</td>
                <td>{{ wallet.balance }}</td>
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
        }
    }
</script>
<style>

</style>
