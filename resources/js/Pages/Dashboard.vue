<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const user = usePage().props.auth.user;

defineProps({
    totalQuizzes: Number,
    accuracy: Number,
});

onMounted(() => {
    const cards = document.querySelectorAll('.fade-in-up');
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        },
        { threshold: 0.2 }
    );

    cards.forEach((card) => observer.observe(card));
});
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-8 sm:py-12 bg-slate-100 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Kartu utama -->
                <div
                    class="fade-in-up bg-white border-2 border-slate-800 overflow-hidden shadow-[6px_6px_0_#1e293b] sm:shadow-[8px_8px_0_#1e293b] rounded-2xl p-5 sm:p-8 transition-all duration-500"
                >
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-2">
                        Wilujeng Sumping, {{ user.name }}!
                    </h3>
                    <p class="text-slate-600 text-base sm:text-lg mb-4">
                        Senang melihatmu kembali. Lihat progres belajarmu di bawah ini.
                    </p>

                    <hr class="my-6 border-slate-300 border-dashed">

                    <!-- Statistik -->
                    <div
                        class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 text-center"
                    >
                        <div
                            class="fade-in-up bg-slate-50 border-2 border-slate-800 rounded-xl p-4 transition-all duration-500 hover:-translate-y-1 hover:shadow-[4px_4px_0_#1e293b]"
                        >
                            <p class="text-xs sm:text-sm font-bold text-slate-500 uppercase">
                                Level
                            </p>
                            <p class="text-3xl sm:text-4xl font-extrabold text-indigo-600">
                                {{ user.level }}
                            </p>
                        </div>
                        <div
                            class="fade-in-up bg-slate-50 border-2 border-slate-800 rounded-xl p-4 transition-all duration-500 hover:-translate-y-1 hover:shadow-[4px_4px_0_#78350f]"
                        >
                            <p class="text-xs sm:text-sm font-bold text-slate-500 uppercase">
                                Total XP
                            </p>
                            <p class="text-3xl sm:text-4xl font-extrabold text-amber-600">
                                {{ user.xp }}
                            </p>
                        </div>
                        <div
                            class="fade-in-up bg-slate-50 border-2 border-slate-800 rounded-xl p-4 transition-all duration-500 hover:-translate-y-1 hover:shadow-[4px_4px_0_#475569]"
                        >
                            <p class="text-xs sm:text-sm font-bold text-slate-500 uppercase">
                                Kuis Selesai
                            </p>
                            <p class="text-3xl sm:text-4xl font-extrabold text-slate-700">
                                {{ totalQuizzes }}
                            </p>
                        </div>
                        <div
                            class="fade-in-up bg-slate-50 border-2 border-slate-800 rounded-xl p-4 transition-all duration-500 hover:-translate-y-1 hover:shadow-[4px_4px_0_#166534]"
                        >
                            <p class="text-xs sm:text-sm font-bold text-slate-500 uppercase">
                                Akurasi
                            </p>
                            <p class="text-3xl sm:text-4xl font-extrabold text-green-600">
                                {{ accuracy }}%
                            </p>
                        </div>
                    </div>

                    <hr class="my-8 border-slate-300 border-dashed" />

                    <!-- Tombol aksi -->
                    <div class="flex flex-col sm:flex-row gap-4 fade-in-up">
                        <Link
                            :href="route('belajar.index')"
                            class="w-full text-center uppercase font-bold tracking-wider text-base sm:text-lg text-white bg-indigo-500 border-2 border-slate-800 rounded-xl py-3 px-6 shadow-[4px_4px_0_#1e293b] hover:bg-indigo-600 hover:-translate-y-0.5 active:translate-y-0 active:shadow-[2px_2px_0_#1e293b] transition-all duration-200"
                        >
                            Lanjutkan Belajar
                        </Link>

                        <Link
                            :href="route('arena.index')"
                            class="w-full text-center uppercase font-bold tracking-wider text-base sm:text-lg text-slate-800 bg-white border-2 border-slate-800 rounded-xl py-3 px-6 shadow-[4px_4px_0_#d1d5db] hover:bg-slate-50 hover:-translate-y-0.5 active:translate-y-0 active:shadow-[2px_2px_0_#d1d5db] transition-all duration-200"
                        >
                            Uji Kemampuan
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.fade-in-up {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease;
}
.fade-in-up.show {
    opacity: 1;
    transform: translateY(0);
}
</style>
