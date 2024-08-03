<script setup>
import { ref } from 'vue';
import { useForm } from 'laravel-precognition-vue-inertia';
import MazBtn from 'maz-ui/components/MazBtn';
import MazInput from 'maz-ui/components/MazInput';
import MazInputPrice from 'maz-ui/components/MazInputPrice';
import MazPicker from 'maz-ui/components/MazPicker'
import Sidebar from '@/Pages/Admin/Layouts/Sidebar.vue';
import Header from '@/Pages/Admin/Layouts/Header.vue';
import TitleForm from '@/Components/TitleForm.vue';
import InputError from '@/Components/InputError.vue';
import MazTextarea from 'maz-ui/components/MazTextarea';
import UploadFile from "@/Pages/Admin/Svgs/UploadFile.vue";
import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
const toast = useToast();

const form = useForm('post', route('store.raffle'), {
    title: '',
    start: null,
    end: null,
    draw_date: null,
    price_1_coupon: 0,
    price_100_coupons: 0,
    price_250_coupons: 0,
    price_500_coupons: 0,
    price_1000_coupons: 0,
    price_5000_coupons: 0,
    price_10000_coupons: 0,
    description: '',
    photo: null,
});

const imageUrl = ref(null);

const handleImageChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.photo = file;
        imageUrl.value = URL.createObjectURL(file);
    }
};

const deleteImage = () => {
    imageUrl.value = null
    form.photo = null
}

const submit = () => form.submit({
    preserveScroll: true,
    onSuccess: () => {
        form.reset();
        imageUrl.value = null;
        toast.add({ severity: 'success', summary: 'Sucesso!', detail: 'Rifa criada com Sucesso.', life: 10000 });
    },
    onError: (error) => {
        console.log('erro', error)
        toast.add({ severity: 'error', summary: 'Ocorreu um erro!', detail: 'Verifique os campos e tente novamente.', life: 10000 });
    }
});

const validateStart = () => {
    form.validate('start');
    form.validate('end');
};

const validateEnd = () => {
    form.validate('start');
    form.validate('end');
    form.validate('draw_date');
};

const validateDrawDate = () => {
    form.validate('end');
    form.validate('draw_date');
}

const setPrices = () => {
    form.price_1_coupon = 0.07
    form.price_100_coupons = 0.06
    form.price_250_coupons = 0.05
    form.price_500_coupons = 0.04
    form.price_1000_coupons = 0.03
    form.price_5000_coupons = 0.02
    form.price_10000_coupons = 0.01
}
</script>

<template>
    <Sidebar />
    <Toast />
    <div class="sm:ml-16 mb-10">
        <Header label="Criar Rifa" />
        <div class="container px-4 md:mx-auto">
            <form @submit.prevent="submit">
                <div class="grid lg:grid-cols-2 gap-4">
                    <TitleForm label="Informações" class="lg:col-span-2" />
                    <div>
                        <MazInput v-model="form.title" label="Título da rifa" autocomplete="off"
                            @change="form.validate('title')" class="w-full" />
                        <InputError v-if="form.invalid('title')" :message="form.errors.title" />
                    </div>
                    <TitleForm label="Datas" class="lg:col-span-2" />
                    <div>
                        <MazPicker v-model="form.start" format="DD-MM-YYYY HH:mm" label="Data de início da rifa" time
                            @update:model-value="validateStart" class="w-full" :error="form.invalid('start')" />
                        <InputError v-if="form.invalid('start')" :message="form.errors.start" />
                    </div>
                    <div>
                        <MazPicker v-model="form.end" format="DD-MM-YYYY HH:mm" label="Data de término da rifa" time
                            @update:model-value="validateEnd" class="w-full" :error="form.invalid('end')" />
                        <InputError v-if="form.invalid('end')" :message="form.errors.end" />
                    </div>
                    <div>
                        <MazPicker v-model="form.draw_date" format="DD-MM-YYYY" label="Data de sorteio da rifa"
                            @update:model-value="validateDrawDate" class="w-full" :error="form.invalid('draw_date')" />
                        <InputError v-if="form.invalid('draw_date')" :message="form.errors.draw_date" />
                    </div>
                </div>
                <TitleForm label="Preços" class="my-4" />
                <button @click="setPrices" type="button" class="bg-green-400 p-2 rounded-lg mb-2">Set Prices</button>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-7 gap-2">
                    <div>
                        <MazInputPrice v-model="form.price_1_coupon" label="Preço por cupom" currency="BRL"
                            locale="pt-BR" :min="0" :max="100" @formatted="formattedPrice = $event"
                            @update:modelValue="form.validate('price_1_coupon')" class="w-full" />
                        <InputError v-if="form.invalid('price_1_coupon')" :message="form.errors.price_1_coupon" />
                    </div>

                    <div>
                        <MazInputPrice v-model="form.price_100_coupons" label="Preço 100 cupons" currency="BRL"
                            locale="pt-BR" :min="0" :max="100" @formatted="formattedPrice = $event"
                            @update:modelValue="form.validate('price_100_coupons')" class="w-full" />
                        <InputError v-if="form.invalid('price_100_coupons')" :message="form.errors.price_100_coupons" />
                    </div>

                    <div>
                        <MazInputPrice v-model="form.price_250_coupons" label="Preço 250 cupons" currency="BRL"
                            locale="pt-BR" :min="0" :max="100" @formatted="formattedPrice = $event"
                            @update:modelValue="form.validate('price_250_coupons')" class="w-full" />
                        <InputError v-if="form.invalid('price_250_coupons')" :message="form.errors.price_250_coupons" />
                    </div>

                    <div>
                        <MazInputPrice v-model="form.price_500_coupons" label="Preço 500 cupons" currency="BRL"
                            locale="pt-BR" :min="0" :max="100" @formatted="formattedPrice = $event"
                            @update:modelValue="form.validate('price_500_coupons')" class="w-full" />
                        <InputError v-if="form.invalid('price_500_coupons')" :message="form.errors.price_500_coupons" />
                    </div>

                    <div>
                        <MazInputPrice v-model="form.price_1000_coupons" label="Preço 1.000 cupons" currency="BRL"
                            locale="pt-BR" :min="0" :max="100" @formatted="formattedPrice = $event"
                            @update:modelValue="form.validate('price_1000_coupons')" class="w-full" />
                        <InputError v-if="form.invalid('price_1000_coupons')"
                            :message="form.errors.price_1000_coupons" />
                    </div>

                    <div>
                        <MazInputPrice v-model="form.price_5000_coupons" label="Preço 5.000 cupons" currency="BRL"
                            locale="pt-BR" :min="0" :max="100" @formatted="formattedPrice = $event"
                            @update:modelValue="form.validate('price_5000_coupons')" class="w-full" />
                        <InputError v-if="form.invalid('price_5000_coupons')"
                            :message="form.errors.price_5000_coupons" />
                    </div>

                    <div>
                        <MazInputPrice v-model="form.price_10000_coupons" label="Preço 10.000 cupons" currency="BRL"
                            locale="pt-BR" :min="0" :max="100" @formatted="formattedPrice = $event"
                            @update:modelValue="form.validate('price_10000_coupons')" class="w-full" />
                        <InputError v-if="form.invalid('price_10000_coupons')"
                            :message="form.errors.price_10000_coupons" />
                    </div>
                </div>
                <TitleForm label="Informações extras" class="my-4" />
                <div>
                    <MazTextarea v-model="form.description" label="Descrição da rifa..." />
                </div>
                <TitleForm label="Imagem" class="my-4" />
                <div>
                    <div class="flex items-center justify-center w-full" v-if="!imageUrl">
                        <label for="dropzone-file"
                            class="flex flex-col items-center justify-center w-fit p-10 border-2 border-dashed rounded-lg border-gray-300 cursor-pointer bg-gray-50"
                            :class="{ 'border-red-500': form.errors.photo }">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <UploadFile />
                                <p class="mb-2 text-sm text-gray-500 font-semibold">
                                    Clique para selecionar uma imagem
                                </p>
                                <InputError v-if="form.invalid('photo')" :message="form.errors.photo" />
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" @change="handleImageChange" />
                        </label>
                    </div>

                    <div v-if="imageUrl" class="w-full flex flex-col items-center justify-center">
                        <div class="w-fit">
                            <img :src="imageUrl" alt="Selected Image" class="max-w-96 max-h-96 rounded-t-md" />
                            <button class="bg-red-500 hover:bg-red-700 w-full p-2 text-white rounded-b-md" type="button"
                                @click="deleteImage">Remover imagem</button>
                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-end mt-4">
                    <MazBtn class="w-full lg:w-40" type="submit" :disabled="form.processing">CRIAR RIFA</MazBtn>
                </div>
            </form>
        </div>
    </div>

</template>