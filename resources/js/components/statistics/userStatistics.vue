<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <a class="btn btn-sm btn-info" v-on:click.prevent="incomes()">Incomes</a>
        <a class="btn btn-sm btn-info" v-on:click.prevent="expenses()">Expenses</a>

        <td>
            <h4>{{ subject }}</h4>
        </td>
        <br />
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="movement in statistics" :key="movement">
                    <td>{{ category }}</td>
                    <td>{{ value }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    components: {},
    data() {
        return {
            title: "Statistics",
            statistics: [],
            subject: ""
            
        };
    },
    methods: {
        incomes: function() {   
            axios.get("api/statistics/income/"+this.$store.state.user.id)
                .then(response => { 
                this.subject = "Income By Categories";
                this.statistics = response.data});
                console.log(statistics);
    },
    },
    mounted() {},
};
</script>
