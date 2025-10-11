<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Star from '@/Components/Icons/Star.vue';

defineProps({
    topXpUsers: Array,
    topStreakUsers: Array,
});
</script>

<template>
    <Head title="Papan Peringkat" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Papan Peringkat
            </h2>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-8">

                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] sm:rounded-2xl">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="bg-amber-100 p-3 rounded-xl border-2 border-slate-800">
                                <Star class="h-8 w-8 text-amber-500" />
                            </div>
                            <div>
                                <h3 class="text-2xl font-extrabold text-slate-900">XP Tertinggi</h3>
                                <p class="text-slate-600">Para pembelajar paling berdedikasi!</p>
                            </div>
                        </div>
                        <ul class="space-y-4">
                            <li v-for="(user, index) in topXpUsers" :key="user.id" class="flex items-center justify-between bg-slate-50 border-2 border-slate-800 rounded-xl p-4">
                                <div class="flex items-center gap-4">
                                    <div class="font-bold text-slate-500 text-xl w-8 text-center">{{ index + 1 }}</div>
                                    <div>
                                        <p class="font-bold text-lg text-slate-800">{{ user.name }}</p>
                                        <p class="text-sm text-slate-500">Level {{ user.level }}</p>
                                    </div>
                                </div>
                                <div class="font-extrabold text-amber-600 text-xl">{{ user.xp }} XP</div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] sm:rounded-2xl">
                    <div class="p-6 sm:p-8">
                         <div class="flex items-center gap-4 mb-6">
                            <div class="bg-orange-100 p-3 rounded-xl border-2 border-slate-800">
                                🔥
                            </div>
                            <div>
                                <h3 class="text-2xl font-extrabold text-slate-900">Streak Terpanjang</h3>
                                <p class="text-slate-600">Para pembelajar paling konsisten!</p>
                            </div>
                        </div>
                        <ul class="space-y-4">
                            <li v-for="(user, index) in topStreakUsers" :key="user.id" class="flex items-center justify-between bg-slate-50 border-2 border-slate-800 rounded-xl p-4">
                                <div class="flex items-center gap-4">
                                     <div class="font-bold text-slate-500 text-xl w-8 text-center">{{ index + 1 }}</div>
                                    <div>
                                        <p class="font-bold text-lg text-slate-800">{{ user.name }}</p>
                                    </div>
                                </div>
                                <div class="font-extrabold text-orange-600 text-xl">🔥 {{ user.streak_count }}</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
