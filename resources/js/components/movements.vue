<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
            <h2>Current Balance: {{ this.$store.state.wallet.balance}}€</h2>
        </div>

        <stack-modal
                v-if="popupActivo"
                :show="popupActivo"
                title="Movement Detail"
                @close="popupActivo=false">
                <tr>
                    <th v-if="currentMovement.iban">IBAN </th>
                    <th v-if="currentMovement.mb_entity_code">MB Entity Code </th>
                    <th v-if="currentMovement.mb_payment_reference">MB Payment Reference </th>
                    <th v-if="currentMovement.description">Description </th>
                    <th v-if="currentMovement.source_description">Source Description </th>
                    <th v-if="currentMovement.wallet_id">Photo </th> 
                </tr>
                <tr>
                    <th v-if="currentMovement.iban">{{currentMovement.iban}} </th>
                    <th v-if="currentMovement.mb_entity_code">{{currentMovement.mb_entity_code}}  </th>
                    <th v-if="currentMovement.mb_payment_reference">{{currentMovement.mb_payment_reference}}  </th>
                    <th v-if="currentMovement.description">{{currentMovement.description}}  </th>
                    <th v-if="currentMovement.source_description">{{currentMovement.source_description}}  </th>
                    <th v-if="currentMovement.wallet_id">{{currentMovement.wallet_id}}  </th>
                </tr>
        </stack-modal>

        <movement-list 
            :movements="movements"
            :users="users"
            :current-movement="currentMovement" 
            @edit-movement="editMovement"  
            @movement-detail="movementDetail"
            ref="moventsListReference">
        </movement-list>
        <movement-edit 
            v-if="editingMovement"
            :categories="this.$store.state.categories"
            :movement="currentMovement"
            @save-movement="saveMovement"
            @cancel-edit_movement="cancelEditMovement">
        </movement-edit> 

<!--         <div class="alert alert-success" v-if="showSuccess">
            <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
            <strong>{{ successMessage }}</strong>
        </div> -->

        
    </div>
</template>

<script>
    import StackModal from './stackModel';
    import MovementListComponent from './movementList';
    import MovementEditComponent from './movementEdit';

    export default {
        props:['users'],
        data: function () {
            return {
                title: 'Movements',
                editingMovement: false,
                showSuccess: false,
                showFailure: false,
                successMessage: '',
                failMessage: '',
                currentMovement: null,
                movementToPut: null,
                movements: [],
                categories: [],
                popupActivo: false
            };
        },
        methods: {
            getMovements: function () {
                axios.get('api/movements/' + this.$store.state.user.id)
                    .then(response => { 
                        this.movements = response.data.data;

                    });
            },
            editMovement: function (movement) {
                this.currentMovement = movement;
                this.editingMovement = true;
                this.showSuccess = false;
                console.log(this.$store.state.categories);
            },
            movementDetail: function (movement){
                this.currentMovement = movement;
                this.popupActivo = true;
            },
            saveMovement: function (movement) {
                this.editingMovement = false;
                console.log(movement);

                axios.put('api/movements/' + movement.id, movement)
                    .then(response => {
                        this.showSuccess = true;
                        this.successMessage = 'Movement Saved';
                        // Copies response.data.data properties to this.currentUser
                        // without changing this.currentUser reference
                        Object.assign(this.currentMovement, response.data.data);
                        this.currentMovement = null;
                        this.editingMovement = false;
                    });
            },
            cancelEditMovement: function () {
                this.showSuccess = false;
                this.editingMovement = false;
                axios.get('api/movements/' + this.currentMovement.id)
                    .then(response => {
                        // Copies response.data.data properties to this.currentUser
                        // without changing this.currentUser reference
                        Object.assign(this.currentMovement, response.data.data);
                        //this.$refs.UserListReference.currentUser = null;
                    });
            }
        },
        mounted() {
            this.getMovements();
            
        },
        components:{
            'movement-list':MovementListComponent,
            'movement-edit':MovementEditComponent,
            StackModal

        }

    }
</script>

<style>
    @import "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css";

    stack-modal {
        width: 700px;
    }
</style>

