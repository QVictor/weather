<script>
import { ref } from 'vue'
import axios from 'axios';

export default {
    data: function () {
        return {
            companies: [],
            cities: [],
            count: 0
        }
    },
    mounted() {
        var app = this;
        axios.get('/api/cities')
            .then(function (resp) {
                app.cities = resp.data;
                console.log(resp.data);
            })
            .catch(function (resp) {
                console.log(resp);
            });
    }
}
</script>

<template>
    {{ companies }}
</template>
