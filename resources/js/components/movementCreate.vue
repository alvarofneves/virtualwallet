<template>
    <div class="jumbotron">
        <h2>Create Movement</h2>
        <div class="form-group">
            <label for="category_id">Type of Movement:</label>
            <select class="form-control" id="category_id" name="category_id" @change="onChangeTypeMovement()">
	            <option value="external"> External Entity </option>
                <option value="transfer"> Bank Transfer </option>
	        </select>
        </div>
        <div class="form-group">
            <label for="category_id">Category:</label>
            <select class="form-control" id="category_id" name="category_id" >
	            <option v-for="category in typeExpense(categories)" :key="category.id" v-bind:value="category.id"> {{ category.name }} </option>
	        </select>
        </div>

        <div v-if="typeOfMovement == 'external'" class="form-group">
            <label for="inputValue">Value:</label>
            <input
                type="text"
                class="form-control"
                name="value"
                id="inputValue"
                placeholder="Value"
            />
        </div>

        <div v-if="typeOfMovement == 'transfer'" class="form-group">
            <label for="inputValue">Value:</label>
            <input
                type="text"
                class="form-control"
                name="value"
                id="inputValue"
                placeholder="Value"
            />
        </div>

        <div class="form-group">
            <label for="inputValue">Value:</label>
            <input
                type="text"
                class="form-control"
                name="value"
                id="inputValue"
                placeholder="Value"
                @keypress="isNumber($event)"
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
export default {
    props: ['movement', 'categories'],
    data: function() {
        return {
            typeOfMovement: "external",
            newMovement: null
        };
    },
    methods: {
        saveMovement() {
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
                    return category
                }
            })
        },
        isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 44) {
                evt.preventDefault();;
            } else {
                return true;
            }
        }
    }
};
</script>

<style scoped></style>
