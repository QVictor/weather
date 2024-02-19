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
            groupByList: [
                {key: 'day', value: 'По дням'},
                {key: 'month', value: 'По месяцам'},
                {key: 'year', value: 'По годам'},
            ],
            selectedGroupBy: 'day',
            cities: [],
            statisticByCity: [],
            average: [],
            count: 0,

            isChartsDisplay: false,
            charts: [],
        }
    },
    methods: {
        getWeather () {
            let self = this;

            axios.get('api/statistic/get-statistics/' + self.selectedCityId).then((response) => {
                this.statisticByCity = response.data;
            });
            axios.get('api/statistic/get-statistics/' + self.selectedCityId + '/average' + '?group_by=' + self.selectedGroupBy).then((response) => {

                console.log(response.data)

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
    beforeCreate () {
        var app = this;
        axios.get('/api/cities')
            .then(function (resp) {
                app.cities = resp.data.data;
                app.selectedCityId = app.cities[0].open_weather_city_id
                app.getWeather()
            })
            .catch(function (resp) {
            });
    }
}
</script>

<template>
    <h3>Выводим средние значения</h3>

    <div>Выберите город</div>
    <select v-model="selectedCityId" @change="getWeather()">
        <option v-for="city in cities" v-bind:value="city.open_weather_city_id">
            {{ city.name }}
        </option>
    </select>

    <div>Выберите группировку</div>
    <select v-model="selectedGroupBy" @change="getWeather()">
        <option v-for="groupBy in groupByList" v-bind:value="groupBy.key">
            {{ groupBy.value }}
        </option>
    </select>

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
