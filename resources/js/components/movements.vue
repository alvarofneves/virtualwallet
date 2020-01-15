<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
            <h2 v-if="this.$store.state.user.type == 'u' && this.$store.state.wallet != null">Current Balance: {{ parseFloat(this.$store.state.wallet.balance).toFixed(2) }}€</h2>
        </div>

        <stack-modal
            v-if="popupActivo"
            :show="popupActivo"
            title="Movement Detail"
            @close="popupActivo = false">

            <tr>
                <th v-if="currentMovement.iban">IBAN</th>
                <th v-if="currentMovement.mb_entity_code">MB Entity Code</th>
                <th v-if="currentMovement.mb_payment_reference">
                    MB Payment Reference
                </th>
                <th v-if="currentMovement.description">Description</th>
                <th v-if="currentMovement.source_description">
                    Source Description
                </th>
                <th v-if="currentMovement.transfer_wallet_id">Photo</th>
            </tr>
            <tr>
                <th v-if="currentMovement.iban">{{ currentMovement.iban }}</th>
                <th v-if="currentMovement.mb_entity_code">
                    {{ currentMovement.mb_entity_code }}
                </th>
                <th v-if="currentMovement.mb_payment_reference">
                    {{ currentMovement.mb_payment_reference }}
                </th>
                <th v-if="currentMovement.description">
                    {{ currentMovement.description }}
                </th>
                <th v-if="currentMovement.source_description">
                    {{ currentMovement.source_description }}
                </th>
                <th v-if="currentMovement.transfer_wallet_id">
                    <img v-if="this.currentMovementPhoto != ''"
                    height="60" 
                    width="60" 
                    :src="'/storage/fotos/' + this.currentMovementPhoto"
                    />
                </th>
            </tr>
        </stack-modal>

        <movement-edit
            v-if="this.editingMovement"
            :categories="this.categories"
            :movement="this.currentMovement"
            @save-movement="saveMovement"
            @cancel-edit="cancelEditMovement"
        >
        </movement-edit>

        <div>
            <movement-list
                :movements="this.movements"
                :users="this.users"
                :current-movement="this.currentMovement"
                @edit-movement="editMovement"
                @movement-detail="movementDetail"
                ref="moventsListReference"
            >
            </movement-list>
            <pagination 
                :meta_data="meta_data"
                @next="getMovements">
            </pagination>
        </div>
        <!--<div class="alert alert-success" v-if="showSuccess">
            <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
            <strong>{{ successMessage }}</strong>
        </div> -->
    </div>
</template>

<script>
import StackModal from "./stackModel";
import MovementListComponent from "./movementList";
import MovementEditComponent from "./movementEdit";
import PaginationComponent from "./pagination";

export default {
    props: ["users","categories"],
    data: function() {
        return {
            title: "Movements",
            editingMovement: false,
            showSuccess: false,
            showFailure: false,
            successMessage: "",
            failMessage: "",
            currentMovement: null,
            currentMovementPhoto: "",
            movementToPut: null,
            movements: [],
            popupActivo: false,
            meta_data: {
                last_page: null,
                current_page: 1,
                prev_page_url: null
            }
        };
    },
    methods: {
        getMovements: function(page = 1) {
            axios.get("api/movements/" + this.$store.state.user.id, {
                    params: {
                        page
                    }
            })
                .then(response => {
                    this.movements = response.data.data;

                    this.meta_data.last_page = response.data.meta.last_page;
                    this.meta_data.current_page = response.data.meta.current_page;
                    this.meta_data.prev_page_url = response.data.meta.prev_page_url;
                });
        },
        getPhoto: function(id){
            axios.get("api/users/" + id)
            .then(response => {
                this.currentMovementPhoto = response.data.data.photo;
            })
        },
        editMovement: function(movement) {
            this.currentMovement = movement;
            this.editingMovement = true;
            this.showSuccess = false;
        },
        movementDetail: function(movement) {
            if(movement.transfer_wallet_id != null){
                this.getPhoto(movement.transfer_wallet_id);
            }
            this.currentMovement = movement;
            this.popupActivo = true;
        },
        saveMovement: function(movement) {
            this.editingMovement = false;

            axios
                .put("api/movements/" + movement.id, movement)
                .then(response => {
                    this.showSuccess = true;
                    this.successMessage = "Movement Saved";
                    // Copies response.data.data properties to this.currentUser
                    // without changing this.currentUser reference
                    Object.assign(this.currentMovement, response.data.data);
                    this.currentMovement = null;
                    this.editingMovement = false;
                });

        },
        cancelEditMovement: function() {
            this.showSuccess = false;
            this.editingMovement = false;
        }
    },
    mounted() {
        this.getMovements();
    },
    components: {
        "movement-list": MovementListComponent,
        "movement-edit": MovementEditComponent,
        StackModal,
        "pagination": PaginationComponent
    }
};
</script>

<style>
@import "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css";

stack-modal {
    width: 700px;
}
</style>
