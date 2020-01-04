
<script type="text/javascript">

import { Bar } from 'vue-chartjs'
Vue.component( 'vue-chartjs', Bar );

export default{
  extends: Bar,

  props: ['year'],

  data () {
    return {
      gradient: null,
      statistics: []
    }
  },
  methods: {
    updateStatistics: function() {      
      axios.get("api/orderspermonth?year=" + this.year + "-01")
           .then(response => { 
             this.statistics = response.data
             console.log(this.statistics);
             console.log(this.year);

      this.renderChart({
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      datasets: [
        {
          label: 'Data One',
          backgroundColor: this.gradient,
          data: this.statistics
        }
      ]
    }, {responsive: true, maintainAspectRatio: false})


    });
  },
  },
  mounted () {
    /* axios.get("api/orderspermonth?year=2018-01")
           .then(response => { 
             this.statistics = response.data
             console.log(this.statistics);
             console.log(this.year);
             
             this.gradient = this.$refs.canvas.getContext('2d').createLinearGradient(0, 0, 0, 450)
    this.gradient.addColorStop(0, 'rgba(255, 0,0, 0.5)') // show this color at 0%;
    this.gradient.addColorStop(0.5, 'rgba(255, 0, 0, 0.25)'); // show this color at 50%
    this.gradient.addColorStop(1, 'rgba(145, 67, 204, 0.46)'); // show this color at 100%

    this.renderChart({
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      datasets: [
        {
          label: 'Data One',
          backgroundColor: this.gradient,
          data: this.statistics
        }
      ]
    }, {responsive: true, maintainAspectRatio: false})


             }); */

             
             
    
  }, 
}
</script>
