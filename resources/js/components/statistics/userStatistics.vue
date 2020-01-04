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
            <a class="btn btn-primary" v-on:click.prevent="updateChart()">Estatisticas</a>
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
            updateChart(){
                console.log(this.movements );
            }

        },
    mounted() {},
};
</script>
