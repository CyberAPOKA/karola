<script setup>
import { ref } from 'vue';

const number = ref(null);

const sortear = () => {
    number.value = Math.floor(Math.random() * 10);
}
</script>

<template>
    <div class="container mx-auto">
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