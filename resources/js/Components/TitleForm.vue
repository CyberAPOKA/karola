<script setup>
const props = defineProps({
    label: String
});
</script>

<template>
    <div class="flex items-center justify-center w-full">
        <h1 class="text-lg font-medium">{{ props.label }}</h1>
    </div>
</template>