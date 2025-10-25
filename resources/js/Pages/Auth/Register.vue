<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue'; // <-- 1. Impor ref dan onMounted

// 2. Form sudah benar menggunakan 'name' dan ditambah 'g-recaptcha-response'
const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    'g-recaptcha-response': '', // Properti untuk menampung token reCAPTCHA
});

const recaptchaWidgetId = ref(null);

// 3. Fungsi untuk menangkap token reCAPTCHA
const onRecaptchaVerified = (response) => {
    form['g-recaptcha-response'] = response;
};

// 4. Fungsi untuk me-reset reCAPTCHA jika ada error validasi
const onRecaptchaError = () => {
    if (window.grecaptcha && recaptchaWidgetId.value !== null) {
        window.grecaptcha.reset(recaptchaWidgetId.value);
    }
};

const submit = () => {
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
            onRecaptchaError(); // Reset reCAPTCHA setelah submit, apa pun hasilnya
        },
    });
};

// 5. Logika profesional untuk memuat script Google reCAPTCHA
const renderRecaptcha = () => {
    // Pastikan elemen ada sebelum me-render
    const container = document.getElementById('recaptcha-container');
    if (container && typeof window.grecaptcha !== 'undefined') {
        recaptchaWidgetId.value = window.grecaptcha.render('recaptcha-container', {
            // Ambil Site Key dari file .env Anda
            'sitekey': import.meta.env.VITE_RECAPTCHA_SITE_KEY,
            'callback': onRecaptchaVerified,
        });
    }
};

onMounted(() => {
    if (!window.grecaptcha) {
        // Jika script belum ada, buat dan tambahkan ke <head>
        const script = document.createElement('script');
        script.src = 'https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit';
        script.async = true;
        script.defer = true;
        document.head.appendChild(script);

        // Buat callback global yang akan dipanggil Google setelah script dimuat
        window.vueRecaptchaApiLoaded = () => {
            renderRecaptcha();
        };
    } else {
        // Jika script sudah dimuat (misal, navigasi bolak-balik), langsung render
        renderRecaptcha();
    }
});
</script>

<template>
    <GuestLayout>
        <Head title="Daftar" />

        <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-sm">
            <h2 class="text-center text-2xl font-semibold mb-4">Daftar</h2>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="name" value="Nama Lengkap" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Alamat Email" />
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Kata Sandi" />
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Konfirmasi Kata Sandi" />
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div class="mt-4 flex justify-center">
                    <div id="recaptcha-container"></div>
                </div>
                <InputError class="mt-2 text-center" :message="form.errors['g-recaptcha-response']" />

                <div class="mt-6">
                    <PrimaryButton
                        class="w-full justify-center"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Daftar
                    </PrimaryButton>
                </div>
            </form>

            <div class="flex items-center my-6">
                <div class="flex-grow border-t border-gray-300"></div>
                <span class="mx-4 text-xs text-gray-500 uppercase">Atau</span>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>

            <a
                :href="route('login.google')"
                class="w-full inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            >
                <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                    <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"></path>
                    <path fill="#FF3D00" d="M6.306 14.691l6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4C16.318 4 9.656 8.337 6.306 14.691z"></path>
                    <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238C29.211 35.091 26.715 36 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"></path>
                    <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303c-.792 2.237-2.231 4.166-4.087 5.571l.003-.002l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"></path>
                </svg>
                Daftar dengan Google
            </a>

            <p class="text-center text-sm text-gray-600 mt-6">
                Sudah punya akun?
                <Link
                    :href="route('login')"
                    class="text-indigo-600 hover:text-indigo-800 font-medium"
                >
                    Masuk sekarang
                </Link>
            </p>
        </div>
    </GuestLayout>
</template>
