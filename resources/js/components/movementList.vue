<template>
    <div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <!-- <th>Transfer</th> -->
                    <th>Destination</th>
                    <th>Type of Payment</th>
                    <th>Category</th>
                    <!-- <th>IBAN</th>
                <th>MB Entity Code</th>
                <th>MB Payment Reference</th> -->
                    <!-- <th>Description</th>
                <th>Source Description</th> -->
                    <th>Date</th>
                    <th>Start Balance -> End Balance</th>
                    <!-- <th>End Balance</th> -->
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="movement in movements"
                    :key="movement.id"
                    :class="{ active: currentMovement === movement }"
                >
                    <td @click="movementDetail(movement)">{{ movement.id }}</td>

                    <div
                        @click="movementDetail(movement)"
                        v-if="!movement.type"
                    ></div>
                    <div @click="movementDetail(movement)" v-if="movement.type">
                        <div v-if="movement.type == 'e'">
                            <td>Expense</td>
                        </div>
                        <div v-if="movement.type == 'i'">
                            <td>Income</td>
                        </div>
                    </div>

                    <!-- <td>{{ movement.transfer }}</td> -->

                    <td
                        @click="movementDetail(movement)"
                        v-if="!movement.transfer_wallet_id"
                    ></td>
                    <td
                        @click="movementDetail(movement)"
                        v-if="movement.transfer_wallet_id"
                    >
                        <div v-for="user in users" :key="user.id">
                            <div v-if="user.id == movement.transfer_wallet_id">
                                {{ user.email }}
                            </div>
                        </div>
                    </td>

                    <div
                        @click="movementDetail(movement)"
                        v-if="movement.type_payment == 'bt'"
                    >
                        <td>Bank Transfer</td>
                    </div>
                    <div
                        @click="movementDetail(movement)"
                        v-if="movement.type_payment == 'mb'"
                    >
                        <td>Multibank</td>
                    </div>
                    <div
                        @click="movementDetail(movement)"
                        v-if="movement.type_payment == 'c'"
                    >
                        <td>Cash</td>
                    </div>
                    <div
                        @click="movementDetail(movement)"
                        v-if="movement.type_payment == null"
                    >
                        <td></td>
                    </div>

                    <td @click="movementDetail(movement)">
                        {{ movement.category }}
                    </td>
                    <!-- <td>{{ movement.iban }}</td>
                    <td>{{ movement.mb_entity_code }}</td>
                    <td>{{ movement.mb_payment_reference }}</td>  -->
                    <!-- <td>{{ movement.description }}</td>
                    <td>{{ movement.source_description }}</td> -->
                    <td @click="movementDetail(movement)">
                        {{ movement.date }}
                    </td>
                    <td v-if="movement.type == 'e'" @click="movementDetail(movement)">
                        {{ movement.start_balance }}€ - {{ movement.value }}€ = {{ movement.end_balance }}€
                    </td>

                    <td v-if="movement.type == 'i'" @click="movementDetail(movement)">
                        {{ movement.start_balance }}€ + {{ movement.value }}€ = {{ movement.end_balance }}€
                    </td>
                    <!--<td @click="movementDetail(movement)">
                        {{ movement.end_balance }}€
                    </td> -->
                    <td @click="movementDetail(movement)">
                        {{ movement.value }}€
                    </td>
                    <td v-if="$store.state.user.type == 'u'">
                        <a
                            class="btn btn-sm btn-primary"
                            v-on:click.prevent="editMovement(movement)"
                            >Edit</a
                        >
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ["movements", "currentMovement", "users"],
    data: function() {
        return {};
    },
    methods: {
        editMovement(movement) {
            console.log("movimento atual");
            console.log(movement.id);
            this.$emit("edit-movement", movement);
        },
        movementDetail(movement) {
            this.$emit("movement-detail", movement);
        }
    },
    components: {}
};
</script>
<style></style>
