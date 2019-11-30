<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <movement-list 
            :movements="movements" 
            ref="moventsListReference">
        </movement-list>

<!--         <div class="alert alert-success" v-if="showSuccess">
            <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
            <strong>{{ successMessage }}</strong>
        </div> -->

        
    </div>
</template>

<script>
    import MovementListComponent from './movementList';

    export default {
        data: function () {
            return {
                title: 'Movements',
                editingUser: false,
                showSuccess: false,
                showFailure: false,
                successMessage: '',
                failMessage: '',
                currentUser: null,
                movements: [],
                departments: []
            };
        },
        methods: {
            getMovements: function () {
                axios.get('api/movements')
                    .then(response => { this.movements = response.data.data; });
            },
        },
        mounted() {
            this.getMovements();
            // axios.get('api/departments')
            //     .then(response => { this.departments = response.data.data; });
        },
        components:{
            'movement-list':MovementListComponent,

        }

    }
</script>

<style>

</style>

