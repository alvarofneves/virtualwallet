<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
            <h2>Current Balance: {{ this.$store.state.wallet.balance }} €</h2>
        </div>

        <movement-list 
            :movements="movements"
            :users="users"
            :current-movement="currentMovement" 
            @edit-movement="editMovement"  
            ref="moventsListReference">
        </movement-list>
        <movement-edit 
            v-if="editingMovement"
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
                categories: []
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
            'movement-edit':MovementEditComponent

        }

    }
</script>

<style>

</style>

