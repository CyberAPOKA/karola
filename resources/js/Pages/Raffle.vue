<script setup>
import { ref, computed } from 'vue'
import { useForm } from 'laravel-precognition-vue-inertia';
import MazInputNumber from 'maz-ui/components/MazInputNumber';
import MazBtn from 'maz-ui/components/MazBtn';
import WhatsApp from '@/Svgs/WhatsApp.vue'
import Toast from 'primevue/toast';
import InformationCircle from '@/Svgs/InformationCircle.vue'
import { useToast } from "primevue/usetoast";
const toast = useToast();

const props = defineProps({
    raffle: Object
})

const openWhatsApp = () => {
    const whatsappNumber = '+555189226632'; // Número do WhatsApp
    const message = 'Olá, preciso de suporte.'; // Mensagem (opcional)
    const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`; // Link
    window.open(whatsappUrl, '_blank'); // Abrir em nova aba
}

const form = useForm('post', route('create.order', props.raffle.id), {
    amount_1_coupon: 50,
    amount_100_coupons: 0,
    amount_250_coupons: 0,
    amount_500_coupons: 0,
    amount_1000_coupons: 0,
    amount_5000_coupons: 0,
    amount_10000_coupons: 0,
});

const couponPrices = {
    100: parseFloat(props.raffle.price_100_coupons),
    250: parseFloat(props.raffle.price_250_coupons),
    500: parseFloat(props.raffle.price_500_coupons),
    1000: parseFloat(props.raffle.price_1000_coupons),
    5000: parseFloat(props.raffle.price_5000_coupons),
    10000: parseFloat(props.raffle.price_10000_coupons)
};

const totalCoupons = computed(() => {
    return Object.keys(couponPrices).reduce((acc, amount) => {
        return acc + (form[`amount_${amount}_coupons`] || 0) * parseInt(amount);
    }, 0) + (form.amount_1_coupon || 0);
});

const totalAmount = computed(() => {
    let total = Object.keys(couponPrices).reduce((acc, amount) => {
        return acc + (form[`amount_${amount}_coupons`] || 0) * couponPrices[amount] * parseInt(amount);
    }, 0);
    total += (form.amount_1_coupon || 0) * parseFloat(props.raffle.price_1_coupon);
    return total;
});

const submit = () => form.submit({
    preserveScroll: true,
    onSuccess: () => {
        form.reset();
        toast.add({ severity: 'success', summary: 'Sucesso!', detail: 'Rifa atualizada com Sucesso.', life: 10000 });
    },
    onError: (error) => {
        console.log('erro', error)
        toast.add({ severity: 'error', summary: 'Ocorreu um erro!', detail: 'Verifique os campos e tente novamente.', life: 10000 });
    }
});
</script>
<template>
    <div class="bg-gray-50 flex flex-col min-h-screen justify-between">
        <div class="container mx-auto py-20">
            <div class="flex flex-col mx-auto mb-auto max-w-3xl w-full h-auto px-2">

                <div class="flex items-center justify-center w-full">
                    <img :src="'/storage/' + raffle.image_path" alt="Selected Image"
                        class="max-w-96 max-h-96 rounded-t-md" />
                </div>
                {{ $page.props.flash.order }}
                <h1 class="text-2xl font-bold text-purple-500 mt-6">🍀{{ raffle.title }}🍀</h1>
                <div class="grid lg:grid-cols-2 gap-4 mt-6">
                    <div class="flex flex-col gap-4">
                        <div class="bg-white rounded-md p-6 flex gap-4">
                            <img src="../../../public/imgs/rocket.png" alt="" class="bg-green-200 rounded-md p-1">
                            <div class="flex flex-col justify-center">
                                <p class="text-lg font-thin">PARTICIPE POR APENAS</p>
                                <p class="text-2xl font-black">R$ {{ raffle.price_1_coupon }}</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-md p-6 flex gap-4">
                            <img src="../../../public/imgs/rocket.png" alt="" class="bg-green-200 rounded-md p-1">
                            <div class="flex flex-col justify-center">
                                <p class="text-lg font-thin">DATA DO SORTEIO</p>
                                <p class="text-2xl font-black">R$ {{ raffle.price_1_coupon }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-md flex flex-col gap-2 justify-center items-center p-6 ">
                        <p class="font-thin text-gray-500">Organizador</p>
                        <p class="text-lg font-black">Karola Prêmios</p>
                        <button @click="openWhatsApp"
                            class="bg-green-700 text-white rounded-md py-2 px-8 flex items-center justify-center gap-2">
                            <WhatsApp /> <span>Suporte</span>
                        </button>
                    </div>
                </div>
                <div class="mt-6">
                    <form @submit.prevent="submit">
                        <!-- Cupom sections -->
                        <div v-for="(price, amount) in couponPrices" :key="amount"
                            class="border-b border-gray-300 py-3 flex items-center justify-between px-2">
                            <div class="flex flex-col justify-between">
                                <h1 class="text-gray-800 text-sm font-bold">
                                    {{ amount }} cupons por R$ {{ (price * amount).toFixed(2) }}
                                </h1>
                                <p class="text-gray-500 text-xs">
                                    Cada cupom sai por R$ {{ price.toFixed(2) }}
                                </p>
                            </div>
                            <MazInputNumber v-model="form[`amount_${amount}_coupons`]" :min="0" :step="1" :max="99999"
                                color="secondary" class="min-w-44 lg:min-w-52" />
                        </div>
                        <!-- 1 Cupom Section -->
                        <div class="border-b border-gray-300 py-3 flex items-center justify-between px-2">
                            <div class="flex flex-col justify-between">
                                <h1 class="text-gray-800 text-sm font-bold">
                                    1 cupom por R$ {{ parseFloat(raffle.price_1_coupon).toFixed(2) }}
                                </h1>
                            </div>
                            <MazInputNumber v-model="form.amount_1_coupon" :min="0" :step="1" :max="99999"
                                color="secondary" class="min-w-44 lg:min-w-52" />
                        </div>
                        <!-- Totals -->
                        <div class="bg-gray-100 rounded-lg mt-4 p-4">
                            <div class="flex justify-between">
                                <h1 class="text-gray-800 text-lg font-black">Total de cupons:</h1>
                                <span class="text-gray-800 text-lg font-black">{{ totalCoupons }}</span>
                            </div>
                            <div class="flex justify-between">
                                <h1 class="text-gray-800 text-lg font-black">Valor total:</h1>
                                <span class="text-gray-800 text-lg font-black">R$ {{ totalAmount.toFixed(2) }}</span>
                            </div>
                            <div class="flex flex-col lg:flex-row items-center gap-2 bg-orange-100 p-4 rounded-md mt-4"
                                :class="{ 'hidden': totalCoupons >= 50 }">
                                <InformationCircle />
                                <h2 class="text-orange-500 font-bold text-lg">Atenção!</h2>
                                <span class="text-orange-500 font-normal">Pedido mínimo de 50 cupons.</span>
                            </div>
                            <button class="w-full mt-4 bg-blue-500 rounded-md p-4 text-white font-bold"
                                :disabled="totalCoupons < 50"
                                :class="{ 'opacity-25': totalCoupons < 50 }">CONFIRMAR</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</template>