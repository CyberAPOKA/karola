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

const form = useForm('post', route('store.raffle'), {
    title: '',
    start: null,
    end: null,
    price_1_coupon: null,
    price_100_coupons: null,
    price_250_coupons: null,
    price_500_coupons: null,
    price_1000_coupons: null,
    price_5000_coupons: null,
    price_10000_coupons: null,
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
    },
});

const validateStart = () => {
    form.validate('start');
    form.validate('end');
};

const validateEnd = () => {
    form.validate('end');
};

const setPrices = () => {
    form.price_1_coupon = 0.50
    form.price_100_coupons = 0.50
    form.price_250_coupons = 0.50
    form.price_500_coupons = 0.50
    form.price_1000_coupons = 0.50
    form.price_5000_coupons = 0.50
    form.price_10000_coupons = 0.50
}
</script>

<template>
    <Sidebar />
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
                        <MazPicker v-model="form.start" format="DD-MM-YYYY HH:mm"
                            label="Selecione a data de início da rifa" time @update:model-value="validateStart"
                            class="w-full" :class="{ 'border !border-red-500 rounded-xl': form.errors.start }" />
                        <InputError v-if="form.invalid('start')" :message="form.errors.start" />
                    </div>
                    <div>
                        <MazPicker v-model="form.end" format="DD-MM-YYYY HH:mm"
                            label="Selecione a data de término da rifa" time @update:model-value="validateEnd"
                            class="w-full" :class="{ 'border !border-red-500 rounded-xl': form.errors.end }" />
                        <InputError v-if="form.invalid('end')" :message="form.errors.end" />
                    </div>
                </div>
                <TitleForm label="Preços" class="my-4" />
                <button @click="setPrices" type="button" class="bg-green-400 p-2 rounded-lg mb-2">Set Prices</button>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-7 gap-2">
                    <div>
                        <MazInputPrice v-model="form.price_1_coupon" label="Preço por cupom" currency="BRL"
                            locale="pt-BR" :min="0" :max="100" @formatted="formattedPrice = $event"
                            @change="form.validate('price_1_coupon')" class="w-full" />
                        <InputError v-if="form.invalid('price_1_coupon')" :message="form.errors.price_1_coupon" />
                    </div>

                    <div>
                        <MazInputPrice v-model="form.price_100_coupons" label="Preço 100 cupons" currency="BRL"
                            locale="pt-BR" :min="0" :max="100" @formatted="formattedPrice = $event"
                            @change="form.validate('price_100_coupons')" class="w-full" />
                        <InputError v-if="form.invalid('price_100_coupons')" :message="form.errors.price_100_coupons" />
                    </div>

                    <div>
                        <MazInputPrice v-model="form.price_250_coupons" label="Preço 250 cupons" currency="BRL"
                            locale="pt-BR" :min="0" :max="100" @formatted="formattedPrice = $event"
                            @change="form.validate('price_250_coupons')" class="w-full" />
                        <InputError v-if="form.invalid('price_250_coupons')" :message="form.errors.price_250_coupons" />
                    </div>

                    <div>
                        <MazInputPrice v-model="form.price_500_coupons" label="Preço 500 cupons" currency="BRL"
                            locale="pt-BR" :min="0" :max="100" @formatted="formattedPrice = $event"
                            @change="form.validate('price_500_coupons')" class="w-full" />
                        <InputError v-if="form.invalid('price_500_coupons')" :message="form.errors.price_500_coupons" />
                    </div>

                    <div>
                        <MazInputPrice v-model="form.price_1000_coupons" label="Preço 1.000 cupons" currency="BRL"
                            locale="pt-BR" :min="0" :max="100" @formatted="formattedPrice = $event"
                            @change="form.validate('price_1000_coupons')" class="w-full" />
                        <InputError v-if="form.invalid('price_1000_coupons')"
                            :message="form.errors.price_1000_coupons" />
                    </div>

                    <div>
                        <MazInputPrice v-model="form.price_5000_coupons" label="Preço 5.000 cupons" currency="BRL"
                            locale="pt-BR" :min="0" :max="100" @formatted="formattedPrice = $event"
                            @change="form.validate('price_5000_coupons')" class="w-full" />
                        <InputError v-if="form.invalid('price_5000_coupons')"
                            :message="form.errors.price_5000_coupons" />
                    </div>

                    <div>
                        <MazInputPrice v-model="form.price_10000_coupons" label="Preço 10.000 cupons" currency="BRL"
                            locale="pt-BR" :min="0" :max="100" @formatted="formattedPrice = $event"
                            @change="form.validate('price_10000_coupons')" class="w-full" />
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
                    <MazBtn class="w-full lg:w-40" type="submit">CRIAR RIFA</MazBtn>
                </div>
            </form>
        </div>
    </div>

</template>