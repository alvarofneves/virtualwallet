<template>
    <div class="jumbotron">
        <pre>
            {{ $v.tranferValue }}
        </pre>
        <h2>Create Movement</h2>
        <div class="form-group">
            <label for="category_id">Type of Movement:</label>
            <select class="form-control" id="category_id" name="category_id" @change="onChangeTypeMovement()">
	            <option value="external"> External Entity </option>
                <option value="transfer"> Bank Transfer </option>
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
         <p v-if="isSubmitted && !$v.tranferValue.minLength">Min value 0,01€</p>
         <p v-if="isSubmitted && !$v.tranferValue.maxLength">Max value 5000€</p>

        <div class="form-group">
            <label for="category_id">Category:</label>
            <select class="form-control" id="category_id" name="category_id" >
	            <option v-for="category in typeExpense(categories)" :key="category.id" v-bind:value="category.id"> 
                    {{ category.name }}
                </option>
	        </select>
        </div>

        <div class="form-group">
            <label for="inputValue">Description:</label>
            <input
                type="text"
                class="form-control"
                name="description"
                id="inputDescription"
                placeholder="Description"
            />
        </div>

        <div v-if="typeOfMovement == 'transfer'" class="form-group">
            <label for="inputValue">IBAN:</label>
            <input
                required
                type="text"
                class="form-control"
                name="iban"
                id="inputIban"
                placeholder="IBAN"
            />
        </div>

        <div v-if="typeOfMovement == 'transfer'" class="form-group">
            <label for="inputValue">Destination's E-mail:</label>
            <input
                required
                type="email"
                class="form-control"
                name="destEmail"
                id="inputDestEmail"
                placeholder="Destination's E-mail"
            />
        </div>

        <div v-if="typeOfMovement == 'external'" class="form-group">
            <label for="inputValue">MB Entity Code:</label>
            <input
                class="form-control"
                name="mBEntityCode"
                id="inputMBentityCode"
                placeholder="MB Entity Code"
            />
        </div>

        <div v-if="typeOfMovement == 'external'" class="form-group">
            <label for="inputValue">MB Entity Reference:</label>
            <input
                type="text"
                class="form-control"
                name="mBEntityReference"
                id="inputMBEntityReference"
                placeholder="MB Entity Reference"
            />
        </div>

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
} from "vuelidate/lib/validators";

export default {
    props: ['movement', 'categories'],
    data: function() {
        return {
            typeOfMovement: "external",
            newMovement: "",
            tranferValue: this.tranferValue,
            category: "",
            description: "",
            iban: "",
            destEmail: "",
            mBEntityCode: "",
            mBEntityReference: "",
            isSubmitted: false
        };
    },
    validations: {
        tranferValue: { 
            required,
            minlength: minLength(0),
            maxlength: maxLength(5000)
            },
        iban: { 
            required,
            length: 23
        },
        destEmail: {
            email
        },
        mBEntityCode: {
            length: 5
        },
        mBEntityReference:{
            length: 9
        }
    },
    methods: {
        saveMovement() {
            this.isSubmitted = true;

            this.newMovement.type = "e";
            this.newMovement.wallet_id = this.$store.state.wallet.id;
            this.newMovement.tranferValue = this.tranferValue;
            this.newMovement.start_balance = this.$store.state.wallet.balance;
            this.newMovement.end_balance = this.newMovement.start_balance - this.tranferValue;
            this.newMovement.category_id = category.id;
            this.newMovement.category = this.category;
            this.newMovement.description = this.description;

            //Get today's Date
            /*var today = new Date();
            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            var dateTime = date + ' ' + time;*/

            //this.newMovement.date = dateTime;

            if(typeOfMovement == "external"){
                this.newMovement.transfer = 0;
                this.newMovement.type_payment = "mb";
                this.newMovement.mb_entity_code = this.mBEntityCode;
                this.newMovement.mb_payment_reference = this.mBEntityReference;

                axios.post("api/movements", {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        nif: this.nif,
                        photo: this.photo
                    })

            }else{
                this.newMovement.transfer = 1;
                this.newMovement.type_payment = "bt";
                this.newMovement.iban = this.iban;
                //this.newMovement.email = 


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

<style scoped></style>
