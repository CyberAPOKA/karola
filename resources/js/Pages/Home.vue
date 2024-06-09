<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
const props = defineProps({
    raffles: Array
})

const number = ref(null);

const sortear = () => {
    number.value = Math.floor(Math.random() * 10);
}
</script>

<template>

    <div class="container mx-auto mt-12">
        <div class="mb-6">
            USER: {{ $page.props.auth.user.name }}
        </div>
        <div class="grid grid-cols-4 gap-4">
            <Link v-for="raffle in raffles" :key="raffle.id" class="flex flex-col border p-4"
                :href="route('raffle', raffle.id)">
            <h1>{{ raffle.title }}</h1>
            <h2>{{ raffle.price }}</h2>
            </Link>
        </div>
        <div class="mt-20">
            <button @click="sortear">
                Sortear
            </button>
            <div>
                Número sorteado: {{ number }}
            </div>
            <div v-if="number === 5">
                Você ganhou
            </div>
        </div>
    </div>
</template>