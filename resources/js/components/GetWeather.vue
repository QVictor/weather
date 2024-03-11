<script>
import axios from 'axios';
import GetAirPollution from "./GetAirPollution.vue";
import GetAverageWeather from "./GetAverageWeather.vue";

export default {
    components: {
        'get-air-pollution': GetAirPollution,
        'get-average-weather': GetAverageWeather
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
        }
    },
    beforeCreate () {
        var app = this;
        axios.get('/api/cities')
            .then(function (resp) {
                app.cities = resp.data.data;
                app.selectedCityId = app.cities[0].open_weather_city_id
            })
            .catch(function (resp) {
            });
    }
}
</script>

<template>
    <h3>Выводим средние значения</h3>

    <div>Выберите город</div>
    <select v-model="selectedCityId">
        <option v-for="city in cities" v-bind:value="city.open_weather_city_id">
            {{ city.name }}
        </option>
    </select>

    <div>Выберите группировку</div>
    <select v-model="selectedGroupBy">
        <option v-for="groupBy in groupByList" v-bind:value="groupBy.key">
            {{ groupBy.value }}
        </option>
    </select>

    <get-air-pollution
        :selectedCityId = this.selectedCityId
        :selectedGroupBy = this.selectedGroupBy
    ></get-air-pollution>

    <get-average-weather
        :selectedCityId = this.selectedCityId
        :selectedGroupBy = this.selectedGroupBy
    ></get-average-weather>
</template>

