<script setup>
const props = defineProps({
    label: String
});
</script>

<template>
    <div class="flex items-center justify-center w-full my-10">
        <h1 class="text-2xl font-semibold">{{ props.label }}</h1>
    </div>
</template>