<script>
import axios from 'axios';
import BarChart from './BarChart.vue';


export default {
    components: {
        'bar-chart': BarChart
    },
    data: function () {
        return {
            selectedCityId: '',
            cities: [],
            statisticByCity: [],
            average: [],
            count: 0,

            isChartsDisplay: false,
            charts: [],
        }
    },
    methods: {
        getWeather (selectedCity) {
            axios.get('api/statistic/get-statistics/' + selectedCity).then((response) => {
                this.statisticByCity = response.data;
            });
            axios.get('api/statistic/get-statistics/' + selectedCity + '/average').then((response) => {
                let self = this;
                console.log(response.data)

                self.charts = [];
                let labels = [];
                let dataAvgTemp = [];
                let dataAvgWindSpeed = [];
                let dataAvgHumidity = [];
                response.data.data.forEach(function (value, key) {
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
        getChartData(label, labels, data) {
            return {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data
                }]
            }
        }
    },
    beforeCreate () {
        var app = this;
        axios.get('/api/cities')
            .then(function (resp) {
                app.cities = resp.data.data;
                app.selectedCityId = app.cities[0].open_weather_city_id
                app.getWeather(app.selectedCityId)
            })
            .catch(function (resp) {
            });
    }
}
</script>

<template>
    <select v-model="selectedCityId" @change="getWeather(selectedCityId)">
        <option disabled value="">Выберите один из вариантов</option>
        <option v-for="city in cities" v-bind:value="city.open_weather_city_id">
            {{ city.name }}
        </option>
    </select>
    <span>Выбрано: {{ selectedCityId }}</span>
    <div style="overflow: hidden;">
        <bar-chart
            v-for="chart in this.charts"
            v-bind:chartData=chart
        ></bar-chart>
    </div>
</template>
