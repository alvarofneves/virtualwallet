<template>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Origin</th>
                <th>Type</th>
                <th>Transfer</th>
                <th>Destination</th>
                <th>Type Payment</th>
                <th>Category Name</th>
                <th>IBAN</th>
                <th>MB Entity Code</th>
                <th>MB Payment Reference</th>
                <!-- <th>Description</th>
                <th>Source Description</th> -->
                <th>Date</th>
                <th>Start Balance</th>
                <th>End Balance</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="movement in movements" :key="movement.id">
                <td>{{ movement.wallet_id }}</td>
                <td>{{ movement.type }}</td>
                <td>{{ movement.transfer }}</td>
                <td>{{ movement.transfer_wallet_id }}</td>            
                <td>{{ movement.type_payment }}</td>
                <td>{{ movement.category_id }}</td>
                <td>{{ movement.iban }}</td>
                <td>{{ movement.mb_entity_code }}</td>
                <td>{{ movement.mb_payment_reference }}</td>            
                <!-- <td>{{ movement.description }}</td>
                <td>{{ movement.source_description }}</td> -->
                <td>{{ movement.date }}</td>
                <td>{{ movement.start_balance }}</td>
                <td>{{ movement.end_balance }}</td>            
                <td>{{ movement.value }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['movements'],
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
