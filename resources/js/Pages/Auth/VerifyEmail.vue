<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <GuestLayout>
        <Head title="Verifikasi Email" />

        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-sm">
            <h2 class="text-center text-2xl font-semibold mb-4">Verifikasi Email</h2>

            <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                Terima kasih sudah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda
                dengan mengeklik tautan yang baru saja kami kirimkan. Jika belum menerima email,
                kami dapat mengirimkan yang baru.
            </p>

            <div
                v-if="verificationLinkSent"
                class="mb-4 text-sm font-medium text-green-600 bg-green-50 p-3 rounded-md text-center"
            >
                Tautan verifikasi baru telah dikirim ke alamat email yang Anda gunakan saat pendaftaran.
            </div>

            <form @submit.prevent="submit" class="space-y-4">
                <PrimaryButton
                    class="w-full justify-center"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Kirim Ulang Email Verifikasi
                </PrimaryButton>

                <div class="text-center">
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Keluar
                    </Link>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>
