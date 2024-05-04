<script setup>
import { useForm } from 'laravel-precognition-vue-inertia';

const form = useForm('post', route('raffle.create'), {
    name: '',
    email: '',
});

const submit = () => form.submit({
    preserveScroll: true,
    onSuccess: () => form.reset(),
});
</script>

<template>
    <div>
        <div class="container mx-auto">

        </div>
    </div>
</template>