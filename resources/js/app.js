import { createApp } from 'vue'
import GetWeather from './components/GetWeather.vue'

const app = createApp()

app.component('get_weather', GetWeather)

app.mount('#app')
