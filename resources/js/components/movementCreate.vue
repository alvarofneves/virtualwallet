<template>
    <div class="jumbotron">
        <pre>
            {{ $v.description }}
        </pre>
        <h2>Create Movement</h2>
        <div class="form-group">
            <label for="category_id">Type of Movement:</label>
            <select class="form-control" 
                    id="category_id" 
                    name="category_id" 
                    v-model="typeOfMovement">
	            <option value="external"> External Entity </option>
                <option value="transfer"> Transfer </option>
	        </select>
        </div>

        <div v-if="typeOfMovement == 'external'" class="form-group">
            <label for="category_id">Type of Payment:</label>
            <select class="form-control" 
                    id="category_id" 
                    name="category_id" 
                    v-model="typeOfPayment">
	            <option value="bt"> Bank Transfer </option>
                <option value="mb"> MB Payment </option>
	        </select>
        </div>

        <div class="form-group">
            <label for="inputValue">Value:</label>
            <input
                required
                v-model="tranferValue"
                @change="$v.tranferValue.$touch()"
                type="number"
                class="form-control"
                name="tranferValue"
                id="tranferValue"
                placeholder="Value"
                value
            />
        </div>
         <p v-if="isSubmitted && !$v.tranferValue.required">Value required</p>
         <p v-if="isSubmitted && !$v.tranferValue.between">Transfer value must be between 0,01€ and 5000€</p>

        <div class="form-group">
            <label for="category_id">Category:</label>
            <select class="form-control" id="category_id" name="category_id" v-model="category">
	            <option v-for="category in typeExpense(categories)" 
                        :key="category.id" 
                        v-bind:value="category"> 
                    {{ category.name }}
                </option>
	        </select>
        </div>

        <div class="form-group">
            <label for="inputValue">Description:</label>
            <input
                type="text"
                class="form-control"
                v-model.trim="description"
                @change="$v.description.$touch()"
                name="description"
                id="inputDescription"
                placeholder="Description"
            />
        </div>
        <p v-if="isSubmitted && !$v.description.required">Description required</p>

        <div v-if="typeOfPayment == 'bt' && typeOfMovement == 'external'" class="form-group">
            <label for="inputValue">IBAN:</label>
            <input
                required
                type="text"
                v-model.trim="iban"
                @change="$v.iban.$touch()"
                class="form-control"
                name="iban"
                id="inputIban"
                placeholder="IBAN"
            />
        </div>
        <p v-if="isSubmitted && !$v.iban.required">IBAN required</p>
        <p v-if="isSubmitted && !$v.iban.isIbanValid">Check IBAN format</p>

        <div v-if="typeOfMovement == 'transfer'" class="form-group">
            <label for="inputValue">Destination's E-mail:</label>
            <input
                required
                type="email"
                v-model="destEmail"
                @change="$v.destEmail.$touch()"
                class="form-control"
                name="destEmail"
                id="inputDestEmail"
                placeholder="Destination's E-mail"
            />
        </div>
        <p v-if="isSubmitted && !$v.destEmail.required">EMAIL required</p>
        <p v-if="isSubmitted && !$v.destEmail.email">Invalid EMAIL</p>

        <div v-if="typeOfPayment == 'mb' && typeOfMovement == 'external'" class="form-group">
            <label for="inputValue">MB Entity Code:</label>
            <input
                class="form-control"
                v-model="mBEntityCode"
                @change="$v.mBEntityCode.$touch()"
                name="mBEntityCode"
                id="inputMBentityCode"
                placeholder="MB Entity Code"
            />
        </div>
        <p v-if="isSubmitted && !$v.mBEntityCode.required">MB entity code required</p>
        <p v-if="isSubmitted && !$v.mBEntityCode.mbEntityCodeLength">MB entity code must have 5 digits</p>

        <div v-if="typeOfPayment == 'mb' && typeOfMovement == 'external'" class="form-group">
            <label for="inputValue">MB Entity Reference:</label>
            <input
                type="text"
                class="form-control"
                v-model="mBEntityReference"
                @change="$v.mBEntityReference.$touch()"
                name="mBEntityReference"
                id="inputMBEntityReference"
                placeholder="MB Entity Reference"
            />
        </div>
        <p v-if="isSubmitted && !$v.mBEntityReference.required">MB entity reference required</p>
        <p v-if="isSubmitted && !$v.mBEntityReference.mbEntityReferenceLength">MB entity refrence must have 9 digits</p>

        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="saveMovement()"
                >Save</a
            >
            <a class="btn btn-light" v-on:click.prevent="cancelEdit()"
                >Cancel</a
            >
        </div>
    </div>
</template>
<script>
import {
    required,
    email,
    sameAs,
    minLength,
    maxLength,
    length,
    numeric,
    requiredIf,
    helpers,
    between
} from "vuelidate/lib/validators";

//Vuelidate REGEX validations:
const isIbanValid = helpers.regex("isIbanValid", /^[A-Z]{2}(?:[ ]?[0-9]){23}$/);
const mbEntityCodeLength = helpers.regex("mbEntityCodeLength", /^[0-9]{5}$/);
const mbEntityReferenceLength = helpers.regex("mbEntityReferenceLength", /^[0-9]{9}$/);

export default {
    props: ['users', 'categories'],
    data: function() {
        return {
            typeOfMovement: "external",
            typeOfPayment: "bt",
            newMovement: [],
            tranferValue: "",
            category: null,
            description: "",
            iban: "",
            destEmail: "",
            mBEntityCode: "",
            mBEntityReference: "",
            isSubmitted: false,
            validUserEmailAndWallet: false
        };
    },
    validations: {
        tranferValue: { 
            required,
            between: between(0.01,5000)
        },
        description:{
            required: requiredIf(function(){
                if(this.typeOfMovement === "transfer")
                    return true;
            })
        },
        iban: {
            isIbanValid,
            required: requiredIf(function(){
                if(this.typeOfMovement === "transfer")
                    return true;
            }),
        },
        destEmail: {
            required: requiredIf(function(){
                if(this.typeOfMovement === "transfer")
                    return true;
            }),
            email
        },
        mBEntityCode: {
            mbEntityCodeLength,
            required: requiredIf(function(){
                if(this.typeOfMovement === "external")
                    return true;
            }),
        },
        mBEntityReference:{
            mbEntityReferenceLength,
            required: requiredIf(function(){
                if(this.typeOfMovement === "external")
                    return true;
            }),
        }
    },
    methods: {
        saveMovement() {
            this.validUserEmailAndWallet = false;
            this.isSubmitted = true;

            console.log(this.categories);


            /* this.newMovement.type = "e";
            this.newMovement.wallet_id = this.$store.state.wallet.id;
            this.newMovement.tranferValue = this.tranferValue;
            this.newMovement.start_balance = this.$store.state.wallet.balance;
            this.newMovement.end_balance = this.newMovement.start_balance - this.tranferValue;
            this.newMovement.category_id = category.id;
            this.newMovement.category = this.category;
            this.newMovement.description = this.description; */

            this.iban = this.iban.split(' ').join('');
            //console.log("DEBUG: "+ this.iban);
            //Get today's Date
            var today = new Date();
            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            var dateTime = date + ' ' + time;

            this.newMovement.date = dateTime;

            if(this.typeOfMovement == "external"){
                if(this.typeOfPayment == "bt"){
                    axios.post("api/movements", {
                        wallet_id: this.$store.state.wallet.id,
                        type: "e",
                        transfer: 0,
                        type_payment: this.typeOfPayment,
                        category_id: this.category.id,
                        category: this.category.name,
                        mb_entity_code: this.mBEntityCode,
                        mb_payment_reference: this.mBEntityReference,
                        description: this.description,
                        date: this.date,
                        start_balance: this.$store.state.wallet.balance,
                        end_balance: (this.$store.state.wallet.balance - this.value),
                        value: this.value
                    }).then(response => {
                        console.log(response.data);
                    })
                }else{
                    axios.post("api/movements", {
                        wallet_id: this.$store.state.wallet.id,
                        type: "e",
                        transfer: 0,
                        type_payment: this.typeOfPayment,
                        category_id: this.category.id,
                        category: this.category.name,
                        mb_entity_code: this.mBEntityCode,
                        mb_payment_reference: this.mBEntityReference,
                        description: this.description,
                        date: this.date,
                        start_balance: this.$store.state.wallet.balance,
                        end_balance: (this.$store.state.wallet.balance - this.value),
                        value: this.value
                    }).then(response => {
                        console.log(response.data);
                    })
                }

                
            }else{
                users.forEach(user => {
                    if(user.email == this.destEmail){
                        if(user.type == "u"){
                            this.validUserEmailAndWallet = true;
                        }
                    }
                })

                if(this.validUserEmailAndWallet == true){
                    axios.post("api/movements", {
                        wallet_id: this.$store.state.wallet.id,
                        email: this.email,
                        transfer_wallet_id: this.transfer_wallet_id,
                        type: "e",
                        transfer: 1,
                        category_id: this.category_id,
                        category: this.category,
                        iban: this.iban,
                        mb_entity_code: this.mb_entity_code,
                        mb_payment_reference: this.mb_payment_reference,
                        description: this.description,
                        date: this.date,
                        start_balance: this.$store.state.wallet.balance,
                        end_balance: (this.$store.state.wallet.balance - this.value),
                        value: this.value
                    }).then(response => {
                        console.log(response.data);
                    })
                }
                
            } 

            this.$emit("save-movement", this.movement);
        },
        cancelEdit() {
            this.$store.commit("createMovementToggle");
        },
        onChangeTypeMovement(){
            if(this.typeOfMovement == "external"){
                this.typeOfMovement = "transfer";
            }else{
                this.typeOfMovement = "external";
            }
        },
        typeExpense(categories){
            return this.categories.filter(category => {
                if(category.type == "e"){
                    return category;
                }
            })
        },
        isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 44) {
                evt.preventDefault();
            } else {
                return true;
            }
        }
    },
    mounted() {
        console.log("Current State: ");
        console.log(this.$store.state);
    }
};
</script>

<style scoped>
p {
    color: red;
}
</style>
