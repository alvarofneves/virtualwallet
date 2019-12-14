<template>
    <div class="jumbotron">
        <h2>Edit Movement</h2>
        <div class="form-group">
            <label for="inputDescription">Description</label>
            <input
                type="text"
                class="form-control"
                v-model="movement.description"
                name="description"
                id="inputDescription"
                placeholder="Description"
            />
        </div>
        <div class="form-group">
            <label for="category_id">Category:</label>
            <select class="form-control" id="category_id" name="category_id" v-model="movement.category_id" >
	            <option v-for="category in categories" :key="category.id" v-bind:value="category.id"> {{ category.name }} </option>
	        </select>
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
            newMovement: null
        };
    },
    methods: {
        saveMovement() {
            this.$emit("save-movement", this.movement);
        },
        cancelEdit() {
            this.$emit("cancel-edit");
        }
    }
};
</script>

<style scoped></style>
