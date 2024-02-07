import { createApp } from 'vue'
import GetWeather from './components/GetWeather.vue'

const app = createApp()
app.component('get-weather', GetWeather)

app.mount('#app')
