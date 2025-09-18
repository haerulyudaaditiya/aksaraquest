<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

// --- PERUBAHAN DIMULAI DI SINI ---

// 1. Impor semua komponen ikon secara langsung
import AcademicCap from '@/Components/Icons/AcademicCap.vue';
import Star from '@/Components/Icons/Star.vue';
import CheckBadge from '@/Components/Icons/CheckBadge.vue';

const props = defineProps({
    achievements: Array,
    unlocked: Array,
});

// 2. Buat sebuah "peta" untuk mencocokkan nama dari database dengan komponen yang diimpor
const iconMap = {
    'academic-cap': AcademicCap,
    'star': Star,
    'check-badge': CheckBadge,
};

const isUnlocked = (achievementId) => {
    return props.unlocked.includes(achievementId);
};
</script>

<template>
    <Head title="Prestasi" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Galeri Prestasi</h2>
        </template>
        <div class="py-12 bg-slate-100">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] sm:rounded-2xl p-8">
                    <p class="text-slate-600 mb-8">Berikut adalah lencana-lencana yang bisa kamu dapatkan dengan menunjukkan kemampuanmu di Arena.</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                        <div
                            v-for="achievement in achievements"
                            :key="achievement.id"
                            class="bg-white border-2 border-slate-800 rounded-xl p-4 text-center transition-all duration-300"
                            :class="{ 'opacity-40 grayscale': !isUnlocked(achievement.id) }"
                        >
                            <component
                                :is="iconMap[achievement.icon_url]"
                                class="h-20 w-20 mx-auto mb-2"
                                :class="isUnlocked(achievement.id) ? 'text-indigo-500' : 'text-slate-400'"
                            />
                            <h3 class="font-extrabold text-slate-900">{{ achievement.name }}</h3>
                            <p class="text-sm text-slate-500 mt-1">{{ achievement.description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
