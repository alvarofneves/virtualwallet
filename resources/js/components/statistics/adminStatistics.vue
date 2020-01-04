<template>
<div>
        <div class="jumbotron">
            <h1>Admin Statistics</h1>
        </div>
        <table class="table table-striped">
            <tbody>
                <div class="app">
                    <apexcharts width="550" type="bar" :options="chartOptions" :series="series"></apexcharts>
                    <div>
                        <button @click="updateChart">Update!</button>
                    </div>
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
            anos: [],
            nWallets:[],
            chartOptions: {
                chart: {
                    id: 'vuechart-example',
                },
                xaxis: {
                    categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998],
                    name: 'Months'
                },
            },
            series: [{
                name: 'Wallets',
                data: [30, 40, 45, 50, 49, 60, 70, 81]
            }]
        }
    },
    methods: {
        updateChart() {
            console.log(this.wallets)
            this.wallets.forEach(wallet => {
                //console.log(wallet.created_at.substring(0, 4))
                if(this.anos.includes(wallet.created_at.substring(0, 4))){

                }else{
                    this.anos.push(wallet.created_at.substring(0, 4));
                }
            })
            this.anos = this.sortAnos();
            console.log(this.anos);
            let index = 0;
            this.anos.forEach(ano => {
                this.nWallets[index] = 0;
                this.wallets.forEach(wallet => {
                    if(ano == wallet.created_at.substring(0, 4)){
                        this.nWallets[index]++;
                    }
                })
                index++;
            })

            console.log(this.nWallets)

            const max = 90;
            const min = 20;
            const newData = this.series[0].data.map(() => {
            return Math.floor(Math.random() * (max - min + 1)) + min
            })

            const colors = ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0']

            // Make sure to update the whole options config and not just a single property to allow the Vue watch catch the change.
            this.chartOptions = {
            colors: [colors[Math.floor(Math.random()*colors.length)]]
            };
            // In the same way, update the series option
            this.series = [{
            data: newData
            }]
        },
        sortAnos(){
            let copy = this.anos.slice()
            return copy.sort();
        }
    }
};
</script>