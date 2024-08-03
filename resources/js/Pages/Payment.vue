<script setup>
import { ref } from 'vue'
import axios from 'axios';

const props = defineProps({
    order: Object,
    pix_order: Object
});

const numbers = ref([]);

const submit = () => {
    axios.post(route('confirm.payment', props.order.id), {
        order: props.order,
        pix_order: props.pix_order
    })
    .then(function (response) {
        console.log(response);
        numbers.value = response.data
    })
    .catch(function (error) {
        console.error(error);
    });
}

const simulatePayment = () => {
    axios.post(`/orders/${props.order.id}/simulate-payment`)
        .then(function (response) {
            console.log(response);
            numbers.value = response.data
        })
        .catch(function (error) {
            console.error(error);
        });
}

</script>
<template>
    <div class="bg-gray-50 flex flex-col min-h-screen justify-between">
        <div class="container mx-auto py-20">
            <div class="flex flex-col mx-auto mb-auto max-w-3xl w-full h-auto px-2">

                <div>
                    {{ props.order }}
                </div>

                <div v-if="props.pix_order">
                    <p>Pedido: {{ props.pix_order.code }}</p>
                    <p>Total: R$ {{ (props.pix_order.amount / 100).toFixed(2) }}</p>
                    <p>Status: {{ props.pix_order.status }}</p>
                    <p>Data de Criação: {{ new Date(props.pix_order.created_at).toLocaleString() }}</p>

                    <div v-if="props.pix_order.charges && props.pix_order.charges.length > 0">
                        <p>Método de Pagamento: PIX</p>
                        <div v-for="charge in props.pix_order.charges" :key="charge.id">
                            <div v-if="charge.last_transaction && charge.last_transaction.qr_code_url">
                                <p>Escaneie o QR code abaixo para pagar:</p>
                                <img :src="charge.last_transaction.qr_code_url" alt="QR Code" />
                                <p>Ou copie o código PIX:</p>
                                <textarea :value="charge.last_transaction.qr_code" readonly></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="bg-black text-white p-3" @click="submit">Comprar</button>
                <button class="bg-blue-500 text-white p-3 mt-3" @click="simulatePayment">Simular Pagamento</button>

                {{ numbers }}

            </div>
        </div>
    </div>
</template>
