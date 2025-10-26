<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

// Impor ikon
import AcademicCap from '@/Components/Icons/AcademicCap.vue';
import Star from '@/Components/Icons/Star.vue';
import CheckBadge from '@/Components/Icons/CheckBadge.vue';
import Trophy from '@/Components/Icons/Trophy.vue';
import Bolt from '@/Components/Icons/Bolt.vue';
import Sparkles from '@/Components/Icons/Sparkles.vue';

const props = defineProps({
    achievements: Array,
    unlocked: Array,
});

// Peta ikon
const iconMap = {
    'academic-cap': AcademicCap,
    'star': Star,
    'check-badge': CheckBadge,
    'trophy': Trophy,
    'bolt': Bolt,
    'sparkles': Sparkles,
};

const isUnlocked = (achievementId) => props.unlocked.includes(achievementId);
</script>

<template>
    <Head title="Prestasi" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Galeri Prestasi</h2>
        </template>

        <div class="py-10 bg-slate-100 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="bg-white border-2 border-slate-800 rounded-xl sm:rounded-2xl overflow-hidden shadow-[6px_6px_0_#1e293b] sm:shadow-[8px_8px_0_#1e293b] p-6 sm:p-10 fade-in-up"
                >
                    <p class="text-slate-600 mb-8 text-base sm:text-lg text-center sm:text-left">
                        Berikut adalah lencana-lencana yang bisa kamu dapatkan dengan menunjukkan kemampuanmu di Arena.
                    </p>

                    <div
                        class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5 sm:gap-6"
                    >
                        <div
                            v-for="achievement in achievements"
                            :key="achievement.id"
                            class="group bg-white border-2 border-slate-800 rounded-lg sm:rounded-xl p-4 flex flex-col items-center text-center transition-all duration-300 ease-out transform hover:-translate-y-1 hover:shadow-[6px_6px_0_#1e293b]"
                            :class="{ 'opacity-40 grayscale': !isUnlocked(achievement.id) }"
                        >
                            <component
                                :is="iconMap[achievement.icon_url]"
                                class="h-14 w-14 sm:h-20 sm:w-20 mb-2 transition-transform duration-300 group-hover:scale-110"
                                :class="isUnlocked(achievement.id) ? 'text-indigo-500' : 'text-slate-400'"
                            />
                            <h3
                                class="font-extrabold text-slate-900 text-sm sm:text-base mt-1"
                            >
                                {{ achievement.name }}
                            </h3>
                            <p
                                class="text-xs sm:text-sm text-slate-500 mt-1 leading-snug line-clamp-3"
                            >
                                {{ achievement.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
@keyframes fadeInUp {
    from {
    opacity: 0;
    transform: translateY(20px);
    }
    to {
    opacity: 1;
    transform: translateY(0);
    }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}
</style>
