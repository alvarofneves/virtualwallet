<template>
<div>
        <div class="jumbotron">
            <h1>Admin Statistics</h1>
        </div>
        <table class="table table-striped">
            <tbody>
                <h1 align="center">Nº Wallets Per Year</h1>
                <div class="app">
                    <apexcharts align="center" width="1000" height="500" type="bar" :options="chartOptions" :series="series"></apexcharts>
                </div>
            </tbody>
        </table>
    </div>
</template>
<script>
import VueApexCharts from 'vue-apexcharts'

export default {
    props: ['wallets'],
    components: {
      apexcharts: VueApexCharts,
    },
    data: function() {
        return {
            years: [],
            nWallets:[],
            chartOptions: {
                chart: {
                    id: 'N of Wallets per Year',
                },
                xaxis: {
                    name: 'Months',
                    categories: []
                },
            },
            series: [{
                name: 'Wallets',
                data: []
            }]
        }
    },
    methods: {
        updateChart() {
            console.log(this.wallets)
            this.wallets.forEach(wallet => {
                if(this.years.includes(wallet.created_at.substring(0, 4))){

                }else{
                    this.years.push(wallet.created_at.substring(0, 4));
                }
            })

            this.years = this.sortYears();
            
            let index = 0;
            this.years.forEach(year => {
                this.nWallets[index] = 0;
                this.wallets.forEach(wallet => {
                    if(year == wallet.created_at.substring(0, 4)){
                        this.nWallets[index]++;
                    }
                })
                index++;
            })

            this.series[0].data = this.nWallets;
            this.chartOptions.xaxis.categories = this.years;

            const colors = ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0']

            this.chartOptions = {
                colors: [colors[Math.floor(Math.random()*colors.length)]],
                xaxis: {
                    categories: this.years,
                    name: 'Months'
                },
            };
            
        },
        sortYears(){
            let copy = this.years;
            return copy.sort();
        }
    },
    created() {
        this.updateChart();
    }
};
</script>