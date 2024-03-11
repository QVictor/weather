<template>
    <div class="graphic">
        <Bar :data="chartData" :options="chartOptions"/>
    </div>
</template>

<script>
import {Bar} from 'vue-chartjs'
import {Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
    name: 'BarChart',
    components: {Bar},
    props: {
        chartData: {
            type: Object,
            required: true
        },
        chartOptions: {
            type: Object,
            default: () => {
                return {
                    responsive: true
                }
            }
        }
    }
}
</script>

<style>
.graphic {
    position: relative;
    width:500px;
}
</style>
