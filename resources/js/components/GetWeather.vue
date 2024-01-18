<script>
import {ref} from 'vue'
import axios from 'axios';

export default {
    data: function () {
        return {
            selectedCityId: '',
            cities: [],
            statisticByCity: [],
            count: 0
        }
    },
    methods: {
        getWeather (selectedCity) {
            console.log(selectedCity);
            axios.get('api/statistic/get-statistics/' + selectedCity).then((response) => {
                console.log(response.data);
                this.statisticByCity = response.data;
            });
        }
    },
    beforeCreate () {
        var app = this;
        axios.get('/api/cities')
            .then(function (resp) {
                app.cities = resp.data.data;
                console.log(resp.data);
            })
            .catch(function (resp) {
                console.log(resp);
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
    <p>{{ statisticByCity }}</p>
</template>
