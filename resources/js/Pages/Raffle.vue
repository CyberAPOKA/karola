<script setup>
import { ref } from 'vue'
import MazInputNumber from 'maz-ui/components/MazInputNumber';
import MazBtn from 'maz-ui/components/MazBtn';

const props = defineProps({
    raffle: Object
})

const ticketsAmount = ref(1);
const generatedNumbers = ref([]);

const generateRandomNumbers = () => {
    const maxNumber = 10000;
    let numbers = new Set();

    while (numbers.size < ticketsAmount.value) {
        const randomNumber = Math.floor(Math.random() * maxNumber) + 1;
        numbers.add(randomNumber);
    }

    generatedNumbers.value = Array.from(numbers);
}
</script>

<template>
    <div class="container mx-auto">
        <div class="flex flex-col items-center mt-20">
            <h1>Título: {{ raffle.title }}</h1>
            <h2>Preço por número: {{ raffle.price }}</h2>
            <MazInputNumber v-model="ticketsAmount" placeholder="Enter number" :min="1" :step="1" :max="1000"
                color="secondary" style="min-width: 200px" />
            <div class="grid grid-cols-4 gap-4 mt-2">
                <MazBtn @click="ticketsAmount = 50">50</MazBtn>
                <MazBtn @click="ticketsAmount = 100">100</MazBtn>

                <MazBtn @click="ticketsAmount = 500">500</MazBtn> <!-- @TODO discount 2% -->
                <MazBtn @click="ticketsAmount = 1000">1000</MazBtn>
            </div>
            <h1 class="my-4 text-lg font-bold">Valor total: R$ {{ ticketsAmount * raffle.price }}</h1>
            <MazBtn @click="generateRandomNumbers">Comprar</MazBtn>
        </div>
        <div v-if="generatedNumbers.length > 0">
            <h2>Seus números:</h2>
            <div class="flex flex-wrap gap-2">
                <h1 v-for="number in generatedNumbers" :key="number" class="underline">{{ number }}</h1>
            </div>
        </div>
    </div>
</template>
