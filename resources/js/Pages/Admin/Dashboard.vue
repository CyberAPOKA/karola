<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import axios from 'axios';
import Sidebar from '@/Pages/Admin/Layouts/Sidebar.vue';
import Header from '@/Pages/Admin/Layouts/Header.vue';
import { formatDateTime } from '@/Services/util.js';
import { Link } from '@inertiajs/vue3';

const raffles = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get('/raffles');
        raffles.value = response.data;

    } catch (error) {
        console.error('Erro ao buscar rifas:', error);
    }
});
</script>

<template>
    <Sidebar />
    <div class="sm:ml-16">
        <Header label="Início" />
        <div class="container px-4 md:mx-auto mb-10">
            <div class="grid grid-cols-4 gap-4">
                <div v-for="raffle in raffles" :key="raffle.id">
                    <a :href="route('admin.raffle', raffle.id)" class="flex flex-col gap-2 shadow-lg p-4 rounded-lg">
                        <img :src="'/storage/' + raffle.image_path" alt="" class="w-full h-80 rounded-md object-cover">
                        <h1 class="font-medium text-center">
                            {{ raffle.title }} - {{ raffle.id }} <!-- @TODO REMOVER ID -->
                        </h1>
                        <!-- <h1 class="text-sm font-medium text-center">
                            {{ formatDateTime(raffle.start) }} Até {{ formatDateTime(raffle.end) }}
                        </h1> -->
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
