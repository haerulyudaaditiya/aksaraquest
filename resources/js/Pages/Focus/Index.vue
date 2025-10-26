<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';

// --- PENYESUAIAN: Menerima 'dueAksara' dari controller ---
defineProps({
    masteredAksara: Array,
    dueAksara: Array, // <-- Mengganti nama 'weakAksara'
});

// --- Logika Animasi (Tidak Berubah) ---
onMounted(() => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1 }
    );

    document.querySelectorAll('.fade-in-up').forEach((el, i) => {
        el.style.animationDelay = `${i * 0.01}s`; 
        observer.observe(el);
    });
});
</script>

<style scoped>
@keyframes fade-in-up {
    0% {
    opacity: 0;
    transform: translateY(20px);
    }
    100% {
    opacity: 1;
    transform: translateY(0);
    }
}
.fade-in-up {
    opacity: 0; /* Mulai transparan */
}
.animate-fade-in-up {
    animation: fade-in-up 0.6s ease-out forwards;
}
/* Efek hover ngangkat (Tetap Ada) */
.card-hover {
    transition: all 0.25s ease;
}
.card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 5px 5px 0 #1e293b;
}
</style>

<template>
    <Head title="Tinjauan Harian" /> <AuthenticatedLayout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tinjauan Harian</h2> </template>

    <div class="py-8 sm:py-12 bg-slate-100 px-4">
        <div class="max-w-4xl mx-auto">
        <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[6px_6px_0_#1e293b] rounded-2xl p-4 sm:p-6">

            <div class="mb-8 fade-in-up">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-100 rounded-xl border-2 border-slate-800 flex items-center justify-center">
                <svg class="h-6 w-6 sm:h-8 sm:w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m9.75 3.104.166-.994.84-.945.84.945.166.994M9.75 3.104C8.25 4.232 5.25 6.25 5.25 9.75c0 4.142 3.358 7.5 7.5 7.5s7.5-3.358 7.5-7.5c0-3.5-3-5.518-4.5-6.646M12 9.75a2.25 2.25 0 0 0-2.25 2.25s.034.422.056.634a2.25 2.25 0 0 0 4.388 0c.022-.212.056-.634.056-.634A2.25 2.25 0 0 0 12 9.75Z" />
                </svg>
                </div>
                <div>
                <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900">Perlu Ditinjau</h3>
                <p class="text-slate-600 text-sm sm:text-base">
                    Aksara ini sudah jatuh tempo. Latih kembali untuk memperkuat ingatan jangka panjangmu!
                </p>
                </div>
            </div>

            <div v-if="dueAksara.length > 0" class="space-y-4">
                <div
                v-for="(aksara, index) in dueAksara"
                :key="aksara.id"
                class="fade-in-up card-hover bg-white border-2 border-slate-800 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 shadow-[3px_3px_0_#1e293b]"
                :style="{ animationDelay: `${index * 0.05}s` }"
                >
                <div class="flex items-center gap-4 flex-1">
                    <div class="text-5xl font-bold text-slate-700 font-sunda w-16 text-center">
                        {{ aksara.character }}
                    </div>
                    <div class="flex flex-col justify-center">
                    <p class="text-xl sm:text-2xl font-bold text-indigo-600 capitalize">
                        {{ aksara.latin }}
                    </p>
                    <p class="text-xs sm:text-sm text-slate-500">Aksara Ngalagena</p>
                    </div>
                </div>

                <div class="flex justify-end sm:justify-center">
                    <Link
                        :href="route('fokus.startPractice', aksara.id)"
                        method="post"
                        as="button"
                        class="uppercase font-bold tracking-wider text-xs sm:text-sm text-white bg-indigo-500 border-2 border-slate-800 rounded-lg py-2 px-5 shadow-[3px_3px_0_#1e293b] hover:bg-indigo-600 active:translate-y-[1px] transition-all"
                    >
                        Latih
                    </Link>
                </div>
                </div>
            </div>

            <div v-else class="fade-in-up bg-green-100 border-2 border-green-800 rounded-xl p-6 text-center">
                <p class="font-bold text-green-900 text-lg sm:text-xl">Hebat!</p>
                <p class="text-green-800 text-sm sm:text-base">
                    Kamu sudah menyelesaikan semua tinjauan untuk hari ini. Kembali lagi besok!
                </p>
            </div>
            </div>

            <div class="mt-8 fade-in-up">
            <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 mb-4">Sudah Dikuasai (Belum Jatuh Tempo)</h3>
            <div
                v-if="masteredAksara.length > 0"
                class="flex flex-wrap gap-3 sm:gap-4 justify-center sm:justify-start"
            >
                <div
                v-for="(aksara, index) in masteredAksara"
                :key="aksara.id"
                class="fade-in-up card-hover bg-green-400 text-white border-2 border-green-800 rounded-xl p-4 flex flex-col items-center justify-center w-20 sm:w-24 h-20 sm:h-24 shadow-[3px_3px_0_#15803d]"
                :style="{ animationDelay: `${index * 0.05}s` }"
                >
                <p class="text-3xl sm:text-4xl font-bold font-sunda">{{ aksara.character }}</p>
                <p class="text-xs sm:text-sm font-bold capitalize">{{ aksara.latin }}</p>
                </div>
            </div>
            <div v-else>
                <p class="text-slate-500 text-sm sm:text-base">
                    Belum ada aksara yang dikuasai. Teruslah berlatih!
                </p>
            </div>
            </div>
        </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
