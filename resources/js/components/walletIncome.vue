<template>
    <div class="jumbotron">
        <h2>Create Income</h2>
        <div class="form-group">
            <label for="category_id">Type of Payment:</label>
            <select class="form-control" 
                    id="category_id" 
                    name="category_id" 
                    v-model="typeOfPayment">
	            <option value="bt"> Bank Transfer </option>
                <option value="c"> Cash </option>
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

        <div v-if="typeOfPayment == 'bt'" class="form-group">
            <label for="inputValue">Source Description:</label>
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
        <p v-if="isSubmitted && !$v.description.required">Source Description required</p>

        <div v-if="typeOfPayment == 'bt'" class="form-group">
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

        <div class="form-group">
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

        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="saveIncome()"
                >Save</a
            >
            <a class="btn btn-light" v-on:click.prevent="cancelIncome()"
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

export default {
    props: ['users'],
    data: function() {
        return {
            typeOfPayment: "bt",
            newMovement: [],
            walletDest: [],
            tranferValue: "",
            description: "",
            iban: "",
            destEmail: "",
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
                if(this.typeOfPayment === "bt")
                    return true;
            })
        },
        iban: {
            isIbanValid,
            required: requiredIf(function(){
                if(this.typeOfPayment ==="bt")
                    return true;
            }),
        },
        destEmail: {
            required,
            email
        }
    },
    methods: {
        saveIncome() {
            this.validUserEmailAndWallet = false;
            this.isSubmitted = true;
            this.validUserEmailAndWallet = false;

            console.log(this.users)

            this.users.forEach(user => {
                if(user.email == this.destEmail){
                    if(user.type == "u"){
                        this.validUserEmailAndWallet = true;
                        this.walletDest = user.wallet;
                    }
                }
            })

            if(this.validUserEmailAndWallet == true){
                if(this.typeOfPayment == "bt"){
                    //BANK TRANSFER
                    axios.post("api/movements", {
                        wallet_id: this.walletDest.id,
                        type: "i",
                        transfer: 1,
                        type_payment: this.typeOfPayment,
                        iban: this.iban,
                        source_description: this.description,
                        start_balance: this.walletDest.balance,
                        end_balance: (parseFloat(this.walletDest.balance) + parseFloat(this.tranferValue)),
                        value: this.tranferValue
                    }).then(response => {
                        axios.put("api/wallets/" + this.walletDest.id, {
                            balance: (parseFloat(this.walletDest.balance) + parseFloat(this.tranferValue))
                        }).then(response => {
                            console.log(response.data.data)
                        }).catch(error => {
                            console.log(error.response.data);
                        })
                    })
                }else{
                    //CASH
                    axios.post("api/movements", {
                        wallet_id: this.walletDest.id,
                        type: "i",
                        transfer: 1,
                        type_payment: this.typeOfPayment,
                        start_balance: this.walletDest.balance,
                        end_balance: (parseFloat(this.walletDest.balance) + parseFloat(this.tranferValue)),
                        value: this.tranferValue
                    }).then(response => {
                        axios.put("api/wallets/" + this.walletDest.id, {
                            balance: (parseFloat(this.walletDest.balance) + parseFloat(this.tranferValue))
                        }).then(response => {
                            console.log(response.data.data)
                        }).catch(error => {
                            console.log(error.response.data);
                        })
                    })
                }
            }else{
                console.log("NAO FOI ENCONTRADO NENHUM UTILIZADOR!")
            }
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
                if(category.type == "i"){
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
