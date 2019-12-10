<template>
    <table class="table table-striped">
        <thead>
            <tr>
                <!-- <th>Origin</th> -->
                <th>Type</th>
                <!-- <th>Transfer</th> -->
                <th>Destination</th>
                <th>Type Payment</th>
                <th>Category</th>
                <!-- <th>IBAN</th>
                <th>MB Entity Code</th>
                <th>MB Payment Reference</th> -->
                <!-- <th>Description</th>
                <th>Source Description</th> -->
                <th>Date</th>
                <th>Start Balance</th>
                <th>End Balance</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="movement in movements" :key="movement.id" :class="{active: currentMovement === movement}">
                    <!-- <td>{{ movement.wallet_id }}</td> -->

                    <div v-if="!movement.type">
                    </div>
                    <div v-if="movement.type">
                        <div v-if="movement.type == 'e'">
                            <td >Expense</td>
                        </div>
                        <div v-if="movement.type == 'i'">
                            <td >Income</td>
                        </div>
                    </div>

                    <!-- <td>{{ movement.transfer }}</td> -->

                    <td v-if="!movement.transfer_wallet_id"></td>
                    <td v-if="movement.transfer_wallet_id">
                        <div v-for="user in users" :key="user.id">
                            <div v-if="user.id == movement.transfer_wallet_id">
                                {{ user.email }}
                            </div>
                        </div>
                    </td>
                    
                    <div v-if="movement.type_payment == 'bt'">
                        <td>Bank Transfer</td>
                    </div>
                    <div v-if="movement.type_payment == 'mb'">
                        <td>Multibank</td>
                    </div>
                    <div v-if="movement.type_payment == 'c'">
                        <td>Cash</td>
                    </div>
                    <div v-if="movement.type_payment == null">
                        <td></td>
                    </div> 

                    <td>{{ movement.category }}</td>
                    <!-- <td>{{ movement.iban }}</td>
                    <td>{{ movement.mb_entity_code }}</td>
                    <td>{{ movement.mb_payment_reference }}</td>  -->           
                    <!-- <td>{{ movement.description }}</td>
                    <td>{{ movement.source_description }}</td> -->
                    <td>{{ movement.date }}</td>
                    <td>{{ movement.start_balance }} €</td>
                    <td>{{ movement.end_balance }} €</td>            
                    <td>{{ movement.value }} €</td>
                    <td v-if="$store.state.user.type=='u'">
                        <a class="btn btn-sm btn-primary" v-on:click.prevent="editMovement(movement)">Edit</a>
                    </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['movements','currentMovement','users'],
        data: function () {
            return {
            }
        },
        methods: {
        editMovement(movement) {
                this.$emit('edit-movement', movement);
            }
        }
    }
</script>
<style>

</style>
