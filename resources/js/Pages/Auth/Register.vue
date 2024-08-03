<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputMask from 'primevue/inputmask';
import DatePicker from 'primevue/datepicker';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    phone: '',
    confirm_phone: '',
    birth_date: null,
    cpf: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>

    <Head title="Register" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Nome" />
                <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" autofocus
                    autocomplete="name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full"
                    autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4 lg:grid lg:grid-cols-2 gap-4">
                <div>
                    <InputLabel for="password" value="Senha" />
                    <TextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full"
                        autocomplete="new-password" />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
                <div>
                    <InputLabel for="password_confirmation" value="Confirme a senha" />
                    <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                        class="mt-1 block w-full" autocomplete="new-password" />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>
            </div>

            <div class="mt-4 lg:grid lg:grid-cols-2 gap-4">
                <div class="p-fluid">
                    <InputLabel for="phone" value="Celular" />
                    <InputMask v-model="form.phone" id="phone" mask="(99) 9 9999-9999" placeholder="(99) 9 9999-9999" />
                    <InputError class="mt-2" :message="form.errors.phone" />
                </div>
                <div class="p-fluid">
                    <InputLabel for="confirm_phone" value="Confirme o celular" />
                    <InputMask v-model="form.confirm_phone" id="confirm_phone" mask="(99) 9 9999-9999"
                        placeholder="(99) 9 9999-9999" />
                    <InputError class="mt-2" :message="form.errors.confirm_phone" />
                </div>
            </div>
            <div class="mt-4">
                <InputLabel for="birth_date" value="Data de nascimento" />
                <DatePicker v-model="form.birth_date" class="w-full" dateFormat="dd/mm/yy" />
                <InputError class="mt-2" :message="form.errors.birth_date" />
            </div>

            <div class="mt-4 p-fluid">
                <InputLabel for="cpf" value="CPF" />
                <InputMask v-model="form.cpf" id="cpf" mask="999.999.999-99" placeholder="999.999.999-99" />
                <InputError class="mt-2" :message="form.errors.cpf" />
            </div>

            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                <InputLabel for="terms">
                    <div class="flex items-center">
                        <Checkbox id="terms" v-model:checked="form.terms" name="terms" />

                        <div class="ms-2">
                            I agree to the <a target="_blank" :href="route('terms.show')"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Terms
                                of Service</a> and <a target="_blank" :href="route('policy.show')"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Privacy
                                Policy</a>
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.terms" />
                </InputLabel>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Já tem uma conta?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
