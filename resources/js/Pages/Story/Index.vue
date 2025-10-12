<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    stories: Array,
});
</script>

<template>
    <Head title="Perpustakaan Dongeng" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Perpustakaan Dongeng</h2>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    <Link v-for="story in stories" :key="story.id" :href="route('dongeng.show', story.id)" class="block bg-white border-2 border-slate-800 rounded-2xl overflow-hidden shadow-[8px_8px_0_#1e293b] hover:shadow-[8px_8px_0_#4f46e5] hover:-translate-y-2 transition-all duration-300">
                        <img :src="story.cover_image_url" alt="Sampul Dongeng" class="w-full h-56 object-cover">
                        <div class="p-6">
                            <h3 class="text-xl font-extrabold text-slate-900">{{ story.title }}</h3>
                            <p class="mt-2 text-slate-600 text-sm h-20 overflow-hidden">{{ story.description }}</p>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
