<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Konfirmasi Kata Sandi" />

        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-sm">
            <h2 class="text-center text-2xl font-semibold mb-4">
                Konfirmasi Kata Sandi
            </h2>

            <p class="text-sm text-gray-600 mb-6 leading-relaxed text-center">
                Ini adalah area aman dari aplikasi. Mohon konfirmasi kata sandi Anda sebelum melanjutkan.
            </p>

            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <InputLabel for="password" value="Kata Sandi" />
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                        autofocus
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <PrimaryButton
                    class="w-full justify-center"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Konfirmasi
                </PrimaryButton>
            </form>
        </div>
    </GuestLayout>
</template>
