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
            axios.get('api/statistic/get-statistics/' + self.selectedCityId + '/air-pollution' + '?group_by=' + self.selectedGroupBy).then((response) => {
                let labels = [];
                let dataAvgAirPollution = [];
                let dataAvgCO = [];
                let dataAvgNO2 = [];
                let dataAvgPM2_5 = [];
                let dataAvgSO2 = [];
                response.data.data.forEach(function (value) {
                    labels.push(value.avg_date);
                    dataAvgAirPollution.push(value.avg_air_quality_index);
                    dataAvgCO.push(value.avg_co);
                    dataAvgNO2.push(value.avg_no2);
                    dataAvgPM2_5.push(value.avg_pm2_5);
                    dataAvgSO2.push(value.avg_so2);
                });
                console.log(response.data.data);
                let datasets = [];
                datasets.push(self.getDatasets('Оксид углерода (CO)', self.getRandomColor(), dataAvgCO));
                datasets.push(self.getDatasets('Оксид азота (NO2)', self.getRandomColor(), dataAvgNO2));
                datasets.push(self.getDatasets('Мелкодисперсные частицы (PM2.5)', self.getRandomColor(), dataAvgPM2_5));
                datasets.push(self.getDatasets('Оксид серы (SO2)', self.getRandomColor(), dataAvgSO2));
                self.chartData = this.getChartData(labels, datasets);
                this.isChartsDisplay = true;
            });
        },
        getChartData (labels, datasets) {
            return {
                labels: labels,
                datasets: datasets
            }
        },
        getDatasets(label, color, data) {
            return {
                label: label,
                backgroundColor: color,
                data: data
            }
        },
        getRandomColor () {
            return '#' + Math.floor(Math.random()*16777215).toString(16);
        }
    },
    created () {

    }
}
</script>

<template>
    <h2>Качество воздуха</h2>
    <div class="line-chart">
        <line-chart v-if="this.isChartsDisplay"
                    :chartData=this.chartData>
        </line-chart>
    </div>
</template>

<style>
.line-chart {
    position: relative;
    width: 500px;
}
</style>
