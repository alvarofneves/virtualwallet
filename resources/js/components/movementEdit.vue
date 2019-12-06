<template>
    <div class="jumbotron">
            <h2>Edit Movement</h2>
            <div class="form-group">
                <label for="inputDescription">Description</label>
                <input type="text" class="form-control" v-model="movement.description"
                       name="description" id="inputDescription"
                       placeholder="Description" />
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <select name="type" id="selectType" v-model="movement.type" disabled>
                <option v-for="option in options" :key="option.value" v-bind:value="option.value">
                    {{ option.text }}
                </option>
            </select>
            </div>
            <div class="form-group">
                <a class="btn btn-primary" v-on:click.prevent="saveMovement()">Save</a>
                <a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
            </div>
        </div>
</template>
<script>
    export default {
        props: ['movement'],
        data: function () {
            return {
                options: [
                    { text: 'Expense', value: 'e' },
                    { text: 'Income', value: 'i' }
                ],
            }
        },
        methods: {
            saveMovement(){
                this.$emit('save-movement', this.movement);
            },
            cancelEdit() {
                this.$emit('cancel-edit');
            }
        }
    }
</script>

<style scoped>

</style>