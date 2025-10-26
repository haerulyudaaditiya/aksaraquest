<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import Star from '@/Components/Icons/Star.vue';

defineProps({
    topXpUsers: Array,
    topStreakUsers: Array,
});

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
        el.style.animationDelay = `${i * 0.05}s`; // efek muncul berurutan
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
.animate-fade-in-up {
    animation: fade-in-up 0.6s ease-out forwards;
}
</style>

<template>
    <Head title="Papan Peringkat" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Papan Peringkat
            </h2>
        </template>

        <div class="py-8 sm:py-12 bg-slate-100 px-4">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">

                <!-- XP Tertinggi -->
                <div class="fade-in-up bg-white border-2 border-slate-800 overflow-hidden shadow-[6px_6px_0_#1e293b] rounded-2xl">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-6">
                            <div class="bg-amber-100 p-3 rounded-xl border-2 border-slate-800">
                                <Star class="h-7 w-7 sm:h-8 sm:w-8 text-amber-500" />
                            </div>
                            <div>
                                <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900">XP Tertinggi</h3>
                                <p class="text-slate-600 text-sm sm:text-base">Para pembelajar paling berdedikasi!</p>
                            </div>
                        </div>
                        <ul class="space-y-3 sm:space-y-4">
                            <li
                                v-for="(user, index) in topXpUsers"
                                :key="user.id"
                                class="fade-in-up flex items-center justify-between bg-slate-50 border-2 border-slate-800 rounded-xl p-3 sm:p-4"
                            >
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <div class="font-bold text-slate-500 text-lg sm:text-xl w-6 sm:w-8 text-center">
                                        {{ index + 1 }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-base sm:text-lg">{{ user.name }}</p>
                                        <p class="text-xs sm:text-sm text-slate-500">Level {{ user.level }}</p>
                                    </div>
                                </div>
                                <div class="font-extrabold text-amber-600 text-base sm:text-xl">
                                    {{ user.xp }} XP
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Streak Terpanjang -->
                <div class="fade-in-up bg-white border-2 border-slate-800 overflow-hidden shadow-[6px_6px_0_#1e293b] rounded-2xl">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-6">
                            <div class="bg-orange-100 p-3 rounded-xl border-2 border-slate-800">
                                🔥
                            </div>
                            <div>
                                <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900">Streak Terpanjang</h3>
                                <p class="text-slate-600 text-sm sm:text-base">Para pembelajar paling konsisten!</p>
                            </div>
                        </div>
                        <ul class="space-y-3 sm:space-y-4">
                            <li
                                v-for="(user, index) in topStreakUsers"
                                :key="user.id"
                                class="fade-in-up flex items-center justify-between bg-slate-50 border-2 border-slate-800 rounded-xl p-3 sm:p-4"
                            >
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <div class="font-bold text-slate-500 text-lg sm:text-xl w-6 sm:w-8 text-center">
                                        {{ index + 1 }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-base sm:text-lg">{{ user.name }}</p>
                                    </div>
                                </div>
                                <div class="font-extrabold text-orange-600 text-base sm:text-xl">
                                    🔥 {{ user.streak_count }}
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
