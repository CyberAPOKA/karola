<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    raffles: Array
})

</script>

<template>

    <div class="container mx-auto mt-12">
        <div class="mb-6">
            USER: {{ $page.props.auth?.user?.name }}
        </div>
        <div class="container px-4 md:mx-auto mb-10">
            <div class="grid grid-cols-4 gap-4">
                <div v-for="raffle in raffles" :key="raffle.id">
                    <Link v-for="raffle in raffles" :key="raffle.id" :href="route('raffle', raffle.id)"
                        class="flex flex-col gap-2 shadow-lg p-4 rounded-lg">
                    <img :src="'/storage/' + raffle.image_path" alt="" class="w-full h-80 rounded-md object-cover">
                    <h1 class="font-medium text-center">
                        {{ raffle.title }}
                    </h1>
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>