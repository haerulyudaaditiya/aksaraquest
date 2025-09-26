<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user;

defineProps({
    totalQuizzes: Number,
    accuracy: Number,
});
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] sm:rounded-2xl p-6 sm:p-8">
                    <h3 class="text-3xl font-extrabold text-slate-900 mb-2">Wilujeng Sumping, {{ user.name }}!</h3>
                    <p class="text-slate-600 text-lg">Senang melihatmu kembali. Lihat progres belajarmu di bawah ini.</p>

                    <hr class="my-8 border-slate-300 border-dashed">

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
                        <div class="bg-slate-50 border-2 border-slate-800 rounded-xl p-4">
                            <p class="text-sm font-bold text-slate-500 uppercase">Level</p>
                            <p class="text-4xl font-extrabold text-indigo-600">{{ user.level }}</p>
                        </div>
                        <div class="bg-slate-50 border-2 border-slate-800 rounded-xl p-4">
                            <p class="text-sm font-bold text-slate-500 uppercase">Total XP</p>
                            <p class="text-4xl font-extrabold text-amber-600">{{ user.xp }}</p>
                        </div>
                        <div class="bg-slate-50 border-2 border-slate-800 rounded-xl p-4">
                            <p class="text-sm font-bold text-slate-500 uppercase">Kuis Selesai</p>
                            <p class="text-4xl font-extrabold text-slate-700">{{ totalQuizzes }}</p>
                        </div>
                        <div class="bg-slate-50 border-2 border-slate-800 rounded-xl p-4">
                            <p class="text-sm font-bold text-slate-500 uppercase">Akurasi</p>
                            <p class="text-4xl font-extrabold text-green-600">{{ accuracy }}%</p>
                        </div>
                    </div>

                    <hr class="my-8 border-slate-300 border-dashed">
                    <div class="flex flex-col sm:flex-row gap-4">
                         <Link :href="route('atlas.index')" class="w-full text-center uppercase font-bold tracking-wider text-lg text-white bg-indigo-500 border-2 border-slate-800 rounded-xl py-3 px-6 shadow-[4px_4px_0_#1e293b] hover:bg-indigo-600 hover:-translate-y-0.5 active:translate-y-0 active:shadow-[2px_2px_0_#1e293b] transition-all">
                            Lanjutkan Belajar
                        </Link>
                        <Link :href="route('arena.index')" class="w-full text-center uppercase font-bold tracking-wider text-lg text-slate-800 bg-white border-2 border-slate-800 rounded-xl py-3 px-6 shadow-[4px_4px_0_#d1d5db] hover:bg-slate-50 hover:-translate-y-0.5 active:translate-y-0 active:shadow-[2px_2px_0_#d1d5db] transition-all">
                            Uji Kemampuan
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
