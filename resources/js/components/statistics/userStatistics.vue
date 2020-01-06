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
            <label>Data Final </label>
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
        <br/>
        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="getMovementsBetweenDates()">Get Statistics From Date</a>
        </div>
        <b v-if="this.valid == false"> {{msg}} </b>
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
            dates: [],
            valid: true,
            msg: "",
            incomeMovements: [],
            totalIncomes: [],
            expenseMovements: [],
            totalExpenses: [],
            balance: [],
            balance_dates:[],
            initial_date: null,
            final_date: null,
            series: [
                {
                name: "Income",
                data: []
                },
                {
                name: "Expense",
                data: []
                }
            ],
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
                    text: 'Income by Day',
                    align: 'center'
                },
                grid: {
                    row: {
                        colors: [], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: [],
                }
            },
        }
    },
    methods:{
        getMovementsBetweenDates: function(){
            this.valid = true;

            if(this.initial_date > this.final_date){
                this.valid = false;
                this.msg = "Não pode inserir uma data Inicial maior que uma data Final";
            }

            if(this.initial_date == null){
                this.valid = false;
                this.msg = "Insira a Data Inicial";
            }

            if(this.final_date == null){
                this.valid = false;
                this.msg = "Insira a Data Final";
            }
            
            if(this.valid == true){
                axios.get("api/statistics/income/" + this.$store.state.wallet.id, 
                {
                    params: {
                        from: this.initial_date,
                        to: this.final_date
                    }
                },
                )
                .then(response => {
                    this.incomeMovements = response.data;

                    axios.get("api/statistics/expense/" + this.$store.state.wallet.id, 
                    {
                        params: {
                            from: this.initial_date,
                            to: this.final_date
                        }
                    })
                    .then(response => {
                        console.log(this.incomeMovements)
                        console.log(this.expenseMovements)
                        this.expenseMovements = response.data;

                        this.incomeMovements.forEach(movement => {
                            if(this.dates.includes(movement.date.substring(0, 10))){

                            }else{
                                this.dates.push(movement.date.substring(0, 10));
                            }
                        })

                        this.expenseMovements.forEach(movement => {
                            if(this.dates.includes(movement.date.substring(0, 10))){

                            }else{
                                this.dates.push(movement.date.substring(0, 10));
                            }
                        })
                        
                        let index = 0;
                        this.dates.forEach(date => {
                            this.totalIncomes[index] = 0;
                            this.incomeMovements.forEach(movement => {
                                if(date == movement.date.substring(0, 10)){
                                    this.totalIncomes[index] =+ movement.value;
                                }
                            })
                            index++;
                        })

                        index = 0;
                        this.dates.forEach(date => {
                            this.totalExpenses[index] = 0;
                            this.expenseMovements.forEach(movement => {
                                if(date == movement.date.substring(0, 10)){
                                    this.totalExpenses[index] =+ movement.value;
                                }
                            })
                            index++;
                        })

                        console.log(this.dates)
                        console.log(this.totalIncomes)
                        console.log(this.totalExpenses)

                        this.series[0].data = this.totalIncomes;
                        this.series[1].data = this.totalExpenses;
                        this.chartOptions.xaxis.categories = this.dates;

                        const colors = ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0']

                        this.chartOptions = {
                            colors: ['#008FFB','#FF4560'],
                            xaxis: {
                                categories: this.dates,
                                name: 'Date'
                            },
                        };
                    })
                })
            }else{
                
            }
        }
    },
    mounted() {
        console.log(this.$store.state.user);
    },
};
</script>
<style scoped>
b {
    color: red;
}
</style>