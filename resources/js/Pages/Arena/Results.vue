<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    quiz: Object,
    score: Number,
    correct: Number,
    total: Number,
    xpGained: Number,
    levelUp: Boolean,
    newLevel: Number,
});
</script>

<template>
    <Head title="Hasil Kuis" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Hasil Kuis #{{ quiz.id }}
            </h2>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 text-center">
                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] sm:rounded-2xl">
                    <div class="p-8 sm:p-12">

                        <div class="mx-auto w-fit mb-4">
                           <svg class="h-24 w-24" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <path d="M256 32C132.3 32 32 132.3 32 256s100.3 224 224 224 224-100.3 224-224S379.7 32 256 32zm0 416c-106.1 0-192-85.9-192-192S149.9 64 256 64s192 85.9 192 192-85.9 192-192 192z" fill="#c7d2fe"/>
                                <path d="M369.3 202.7c-4.9-4.9-12.8-4.9-17.7 0L238.4 315.9c-2.1 2.1-5.6 2.1-7.7 0l-53.3-53.3c-4.9-4.9-12.8-4.9-17.7 0s-4.9 12.8 0 17.7l62.1 62.1c6.8 6.8 17.7 6.8 24.5 0l124-124c4.9-4.9 4.9-12.8 0-17.7z" fill="#4f46e5"/>
                            </svg>
                        </div>

                        <h3 class="text-3xl font-extrabold text-slate-900 mb-2">
                            Latihan Selesai!
                        </h3>
                        <p class="text-slate-600 mb-6">
                            Kerja bagus! Berikut adalah hasil pencapaianmu.
                        </p>

                        <div class="my-8">
                            <p class="text-sm font-bold text-slate-500 uppercase">SKOR AKHIR</p>
                            <div class="text-8xl font-extrabold text-indigo-600">
                                {{ score }}
                            </div>
                            <div v-if="levelUp" class="my-8 p-4 bg-yellow-100 border-2 border-yellow-300 rounded-xl animate-pulse">
                                <p class="text-2xl font-extrabold text-yellow-600">
                                    ✨ NAIK LEVEL! ✨
                                </p>
                                <p class="mt-1 font-semibold text-yellow-800">
                                    Selamat, Anda telah mencapai Level {{ newLevel }}!
                                </p>
                            </div>
                            <p v-if="xpGained > 0" class="mt-2 text-xl font-bold text-yellow-500">
                                +{{ xpGained }} XP
                            </p>
                            <p class="text-lg font-semibold text-slate-700 mt-2">
                                Jawaban Benar: {{ correct }} / {{ total }}
                            </p>
                        </div>

                        <div class="mt-10 flex flex-col sm:flex-row-reverse gap-4 justify-center">
                            <Link
                                :href="route('arena.start')"
                                method="post"
                                as="button"
                                class="w-full sm:w-auto uppercase font-bold tracking-wider text-lg text-white bg-indigo-500 border-2 border-slate-800 rounded-xl py-3 px-6 shadow-[4px_4px_0_#1e293b] hover:bg-indigo-600 hover:-translate-y-0.5 active:translate-y-0 active:shadow-[2px_2px_0_#1e293b] transition-all"
                            >
                                Coba Lagi
                            </Link>
                             <Link
                                :href="route('atlas.index')"
                                as="button"
                                class="w-full sm:w-auto uppercase font-bold tracking-wider text-lg text-slate-800 bg-white border-2 border-slate-800 rounded-xl py-3 px-6 shadow-[4px_4px_0_#d1d5db] hover:bg-slate-50 hover:-translate-y-0.5 active:translate-y-0 active:shadow-[2px_2px_0_#d1d5db] transition-all"
                            >
                                Kembali ke Galeri
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
