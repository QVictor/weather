<script>
import axios from 'axios';
import BarChart from "./charts/BarChart.vue";
import LineChart from "./charts/LineChart.vue";

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
        },
        selectedGroupBy: function () {
            this.getAirPollution()
        }
    },
    methods: {
        getAirPollution () {
            let self = this;
            axios.get('api/statistic/get-statistics/' + self.selectedCityId + '/average' + '?group_by=' + self.selectedGroupBy).then((response) => {
                self.charts = [];
                let labels = [];
                let dataAvgTemp = [];
                let dataAvgWindSpeed = [];
                let dataAvgHumidity = [];
                response.data.data.forEach(function (value) {
                    labels.push(value.date);
                    dataAvgTemp.push(value.avg_temp);
                    dataAvgWindSpeed.push(value.avg_wind_speed);
                    dataAvgHumidity.push(value.avg_humidity);
                });
                this.charts.push(this.getChartData('Средняя температура', labels, dataAvgTemp));
                this.charts.push(this.getChartData('Средняя скорость ветра', labels, dataAvgWindSpeed));
                this.charts.push(this.getChartData('Средняя влажность', labels, dataAvgHumidity));
                this.isChartsDisplay = true;
            });
        },
        getChartData (label, labels, data) {
            return {
                labels: labels,
                datasets: [{
                    label: label,
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
    <h2>Средние значения</h2>
    <div class="graphics">
        <bar-chart
            v-for="chart in this.charts"
            v-bind:chartData=chart
        ></bar-chart>
    </div>
</template>

<style>
.graphics {
    overflow: hidden;
    display: flex;
    justify-content: space-between;
}
</style>
