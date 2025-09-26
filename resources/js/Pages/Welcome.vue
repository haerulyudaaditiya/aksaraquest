<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head title="Selamat Datang di AksaraQuest" />

    <div class="antialiased bg-slate-100 text-slate-800">
        <div class="relative min-h-screen flex flex-col items-center justify-center pt-24 pb-12">
            <div class="absolute top-0 right-0 p-6 text-end">
                <div v-if="$page.props.auth.user" class="font-semibold text-gray-600">
                    <Link :href="route('dashboard')" class="hover:text-indigo-600">
                        Dashboard
                    </Link>
                </div>
                <template v-else>
                    <Link v-if="canLogin" :href="route('login')" class="font-bold text-slate-800 hover:text-indigo-600">
                        Log in
                    </Link>
                    <Link v-if="canRegister" :href="route('register')" class="ms-6 font-bold text-slate-800 hover:text-indigo-600">
                        Register
                    </Link>
                </template>
            </div>

            <main class="max-w-4xl mx-auto p-6 lg:p-8 text-center">
                <div class="mx-auto w-fit mb-6">
                   <svg class="h-24 w-24" viewBox="0 0 102 102" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M40.1053 3.84453C44.7368 1.28151 50.2632 1.28151 54.8947 3.84453L76.5789 16.6555C81.2105 19.2185 84 24.1623 84 29.4665V54.9886C84 60.2928 81.2105 65.2366 76.5789 67.8001L54.8947 80.6111C50.2632 83.1741 44.7368 83.1741 40.1053 80.6111L18.4211 67.8001C13.7895 65.2371 11 60.2933 11 54.9886V29.4665C11 24.1623 13.7895 19.2185 18.4211 16.6555L40.1053 3.84453Z" fill="#eef2ff"/>
                        <path d="M40.1053 3.84453C44.7368 1.28151 50.2632 1.28151 54.8947 3.84453L76.5789 16.6555C81.2105 19.2185 84 24.1623 84 29.4665V54.9886C84 60.2928 81.2105 65.2366 76.5789 67.8001L54.8947 80.6111C50.2632 83.1741 44.7368 83.1741 40.1053 80.6111L18.4211 67.8001C13.7895 65.2371 11 60.2933 11 54.9886V29.4665C11 24.1623 13.7895 19.2185 18.4211 16.6555L40.1053 3.84453Z" stroke="#4338ca" stroke-width="4"/>
                        <path d="M47.5 31.5C47.5 28.1863 50.1863 25.5 53.5 25.5C56.8137 25.5 59.5 28.1863 59.5 31.5V55.5C59.5 58.8137 56.8137 61.5 53.5 61.5C50.1863 61.5 47.5 58.8137 47.5 55.5V31.5Z" stroke="#4f46e5" stroke-width="4"/>
                        <path d="M36.5 49.5C36.5 43.1487 41.6487 38 48 38H53.5C56.8137 38 59.5 40.6863 59.5 44V44C59.5 47.3137 56.8137 50 53.5 50H48C41.6487 50 36.5 55.1487 36.5 61.5V61.5" stroke="#4f46e5" stroke-width="4"/>
                    </svg>
                </div>

                <h1 class="text-5xl sm:text-7xl font-extrabold text-slate-900">
                    AksaraQuest
                </h1>
                <p class="mt-4 text-lg text-slate-600">
                    Petualangan modern untuk menguasai Aksara Sunda melalui permainan yang menyenangkan.
                </p>

                <div v-if="canRegister" class="mt-8">
                    <Link :href="route('register')" class="inline-block w-full max-w-xs uppercase font-bold tracking-wider text-lg text-white bg-indigo-500 border-2 border-slate-800 rounded-xl py-3 px-6 shadow-[4px_4px_0_#1e293b] hover:bg-indigo-600 hover:-translate-y-1 active:translate-y-0 active:shadow-[2px_2px_0_#1e293b] transition-all duration-200">
                        Mulai Petualangan
                    </Link>
                </div>
            </main>
        </div>

        <div class="bg-white py-12 sm:py-20 border-y-2 border-slate-800">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center">
                    <h2 class="text-3xl font-extrabold text-slate-900">Platform Belajar Terlengkap</h2>
                    <p class="mt-4 text-lg text-slate-600">
                        Dirancang dengan fitur-fitur canggih untuk membuat proses belajar menjadi efektif dan menyenangkan.
                    </p>
                </div>
                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white border-2 border-slate-800 rounded-2xl p-8 shadow-[8px_8px_0_#d1d5db]">
                        <div class="bg-indigo-100 p-3 rounded-xl w-fit mb-4">
                            <svg class="h-8 w-8 text-indigo-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" /></svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-900">Galeri Interaktif</h3>
                        <p class="mt-2 text-slate-600">Pelajari setiap aksara dengan audio pengucapan dan latihan menulis langsung di kanvas digital.</p>
                    </div>
                    <div class="bg-white border-2 border-slate-800 rounded-2xl p-8 shadow-[8px_8px_0_#d1d5db]">
                         <div class="bg-indigo-100 p-3 rounded-xl w-fit mb-4">
                            <svg class="h-8 w-8 text-indigo-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" /></svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-900">Arena Kuis Cerdas</h3>
                        <p class="mt-2 text-slate-600">Uji kemampuanmu dengan 4 tipe soal berbeda. Sistem kuis adaptif akan fokus pada kelemahanmu.</p>
                    </div>
                    <div class="bg-white border-2 border-slate-800 rounded-2xl p-8 shadow-[8px_8px_0_#d1d5db]">
                         <div class="bg-indigo-100 p-3 rounded-xl w-fit mb-4">
                            <svg class="h-8 w-8 text-indigo-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-6.75c-.621 0-1.125.504-1.125 1.125v3.375m9 0h-9" /></svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-900">Sistem Progresi</h3>
                        <p class="mt-2 text-slate-600">Dapatkan XP, naikkan level, dan kumpulkan lencana prestasi untuk setiap pencapaian belajarmu.</p>
                    </div>
                </div>
            </div>
        </div>

        <footer class="bg-slate-100 py-6 text-center">
            <p class="text-slate-500">
                Dibuat oleh Haerul Yuda Aditiya.
            </p>
        </footer>
    </div>
</template>
