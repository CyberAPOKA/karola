<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import Sidebar from '@/Pages/Admin/Layouts/Sidebar.vue';
import Header from '@/Pages/Admin/Layouts/Header.vue';
import { formatDateTime } from '@/Services/util.js';

const raffles = ref([]);
const countdowns = ref({});

const calculateCountdown = (raffle) => {
    const now = new Date();
    const start = new Date(raffle.start);
    const timeDiff = start - now;

    if (timeDiff <= 0) {
        return "A rifa já começou";
    }

    const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

    const parts = [];
    if (days > 0) parts.push(`${days} dias`);
    if (hours > 0) parts.push(`${hours} horas`);
    if (minutes > 0) parts.push(`${minutes} minutos`);
    if (seconds > 0) parts.push(`${seconds} segundos`);

    return parts.length > 0 ? `Faltam ${parts.join(', ')} para começar` : "A rifa já começou";
};

const updateCountdowns = () => {
    raffles.value.forEach(raffle => {
        countdowns.value[raffle.id] = calculateCountdown(raffle);
    });
};

let interval;
onMounted(async () => {
    try {
        const response = await axios.get('/raffles');
        raffles.value = response.data;

        updateCountdowns();
        interval = setInterval(updateCountdowns, 1000);
    } catch (error) {
        console.error('Erro ao buscar rifas:', error);
    }
});

onUnmounted(() => {
    clearInterval(interval);
});
</script>

<template>
    <Sidebar />
    <div class="sm:ml-16">
        <Header label="Início" />
        <div class="container px-4 md:mx-auto">
            <div class="grid grid-cols-4 gap-4">
                <div v-for="raffle in raffles" :key="raffle.id" class="flex flex-col gap-2 shadow-lg p-4 rounded-lg">
                    <img :src="raffle.image_path" alt="" class="w-full h-full rounded-md">
                    <h1 class="font-medium text-center">
                        {{ raffle.title }} - {{ raffle.id }} <!-- @TODO REMOVER ID -->
                    </h1>
                    <h1 class="text-sm font-medium text-center">
                        {{ formatDateTime(raffle.start) }} Até {{ formatDateTime(raffle.end) }}
                    </h1>
                    <h1 class="text-sm font-medium text-center">{{ countdowns[raffle.id] }}</h1>
                </div>
            </div>
        </div>
    </div>
</template>
