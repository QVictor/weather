import { createApp } from 'vue'
import GetWeather from './components/GetWeather.vue'
import BarChart from "./components/BarChart.vue";

const app = createApp()

app.component('bar_chart', BarChart)
app.component('get_weather', GetWeather)

app.mount('#app')
