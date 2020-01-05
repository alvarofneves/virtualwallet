<template>
    <div>
        <div class="jumbotron">
            <h1>User Statistics</h1>
        </div>
        <div>
            <label>Data Inicial</label>
            <input
                required
                type="date"
                class="col-sm-2 col-form-label"
                v-model="initial_date"
                name="initial_date"
                id="initial_date"
                placeholder="Date"
            />
        </div>
        <div>
            <label>Data Inicial</label>
            <input
                required
                type="date"
                class="col-sm-2 col-form-label"
                v-model="final_date"
                name="final_date"
                id="final_date"
                placeholder="Date"
            />
        </div>
        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="getBalanceBetweenDates()">Estatisticas</a>
        </div>
        <div id="chart">
        <apexchart type="line" height="350" :options="chartOptions" :series="series"></apexchart>
      </div>
    </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
export default {
    props:['wallets'],
    components: {
          apexchart: VueApexCharts,
        },
        data: function() {
            return { 
            balance: [],
            balance_dates:[],
            initial_date:null,
            final_date:null,
            series: [{
                name: "Value",
                data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
            }],
            chartOptions: {
                chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
                },
                dataLabels: {
                enabled: false
                },
                stroke: {
                curve: 'straight'
                },
                title: {
                text: 'Income by Month',
                align: 'left'
                },
                grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
                },
                xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                }
            },
          
          
        }
        },
        methods:{
            getBalanceBetweenDates(initial_date,final_date) {
                    console.log(this.$store.state.user);
                        axios.get("api/statistics/balance/" + this.this.$store.state.user.id)
                        .then(response => {
                            this.balances = response.data.data;})
                            .then(reponse => {
                                axios.get("api/statistics/balance/dates/" + this.this.$store.state.user.id)
                                .then(response => {
                                this.balances_dates = response.data.data;
                                })
                            });
                            
                console.log(this.balances);
                console.log(this.balances_dates);
                console.log(this.$store.state.user);
            },

        },
    mounted() {},
};
</script>
