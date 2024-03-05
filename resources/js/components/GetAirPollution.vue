<script>
import axios from 'axios';
import BarChart from "./BarChart.vue";
import LineChart from "./LineChart.vue";

export default {
    data: function () {
        return {
            isChartsDisplay: false,
            'charts': [],
            chartData: {}
        }
    },
    props: [
        'selectedCityId',
        'selectedGroupBy'
    ],
    components: {
        'line-chart': LineChart,
        'bar-chart': BarChart
    },
    watch: {
        selectedCityId: function () {
            this.getAirPollution()
        }
    },
    methods: {
        getAirPollution () {
            let self = this;

            axios.get('api/statistic/get-statistics/' + self.selectedCityId + '/air-pollution' + '?group_by=' + self.selectedGroupBy).then((response) => {

                console.log(response.data)

                let labels = [];
                let dataAvgAirPollution = [];
                response.data.data.forEach(function (value) {
                    labels.push(value.avg_date);
                    dataAvgAirPollution.push(value.avg_air_quality_index);
                });
                self.chartData = this.getChartData('Качество воздуха', labels, dataAvgAirPollution);
                this.isChartsDisplay = true;
            });
        },
        getChartData (label, labels, data) {
            return {
                labels: labels,
                datasets: [{
                    label: label,
                    backgroundColor: '#f87979',
                    data: data
                }]
            }
        }
    },
    created () {

    }
}
</script>

<template>
    <h2>Air Pollution</h2>
    <div class="line-chart">
        <line-chart v-if="this.isChartsDisplay"
                    :chartData=this.chartData>
        </line-chart>
    </div>
    <!--    <div class="graphics">-->
    <!--        <bar-chart-->
    <!--            v-for="chart in this.charts"-->
    <!--            v-bind:chartData=chart-->
    <!--        ></bar-chart>-->
    <!--    </div>-->
</template>

<style>
.line-chart {
    position: relative;
    //height:500px;
    width: 500px;
}
</style>
