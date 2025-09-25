<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    aksaras: Array,
});
</script>

<template>
    <Head title="The Atlas" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Galeri Aksara
            </h2>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] sm:rounded-2xl">
                    <div class="p-6 sm:p-8">
                        <div class="text-center">
                            <div class="mx-auto w-fit mb-4">
                               <svg class="h-20 w-20" viewBox="0 0 102 102" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M40.1053 3.84453C44.7368 1.28151 50.2632 1.28151 54.8947 3.84453L76.5789 16.6555C81.2105 19.2185 84 24.1623 84 29.4665V54.9886C84 60.2928 81.2105 65.2366 76.5789 67.8001L54.8947 80.6111C50.2632 83.1741 44.7368 83.1741 40.1053 80.6111L18.4211 67.8001C13.7895 65.2371 11 60.2933 11 54.9886V29.4665C11 24.1623 13.7895 19.2185 18.4211 16.6555L40.1053 3.84453Z" fill="#eef2ff"/>
                                    <path d="M40.1053 3.84453C44.7368 1.28151 50.2632 1.28151 54.8947 3.84453L76.5789 16.6555C81.2105 19.2185 84 24.1623 84 29.4665V54.9886C84 60.2928 81.2105 65.2366 76.5789 67.8001L54.8947 80.6111C50.2632 83.1741 44.7368 83.1741 40.1053 80.6111L18.4211 67.8001C13.7895 65.2371 11 60.2933 11 54.9886V29.4665C11 24.1623 13.7895 19.2185 18.4211 16.6555L40.1053 3.84453Z" stroke="#4338ca" stroke-width="4"/>
                                    <path d="M47.5 31.5C47.5 28.1863 50.1863 25.5 53.5 25.5C56.8137 25.5 59.5 28.1863 59.5 31.5V55.5C59.5 58.8137 56.8137 61.5 53.5 61.5C50.1863 61.5 47.5 58.8137 47.5 55.5V31.5Z" stroke="#4f46e5" stroke-width="4"/>
                                    <path d="M36.5 49.5C36.5 43.1487 41.6487 38 48 38H53.5C56.8137 38 59.5 40.6863 59.5 44V44C59.5 47.3137 56.8137 50 53.5 50H48C41.6487 50 36.5 55.1487 36.5 61.5V61.5" stroke="#4f46e5" stroke-width="4"/>
                                </svg>
                            </div>
                            <h3 class="text-3xl font-extrabold text-slate-900 mb-2">
                                Belajar Aksara Sunda
                            </h3>
                            <p class="mt-1 mb-8 text-slate-600 max-w-xl mx-auto">
                                Mulai petualanganmu! Kenali setiap karakter aksara dasar dan buka jalanmu untuk menjadi seorang master.
                            </p>
                        </div>

                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-5">
                            <Link
                                v-for="aksara in aksaras"
                                :key="aksara.id"
                                :href="route('atlas.show', aksara.id)"
                                class="block bg-white border-2 border-slate-800 rounded-xl p-4 flex flex-col items-center justify-center aspect-square shadow-[4px_4px_0_#1e293b] hover:shadow-[4px_4px_0_#4f46e5] hover:-translate-y-1 hover:-translate-x-1 transition-all duration-200 cursor-pointer group"
                            >
                                <p class="text-6xl font-bold text-slate-700 transition-colors group-hover:text-indigo-600 font-sunda">
                                    {{ aksara.character }}
                                </p>
                                <p class="mt-2 text-lg font-medium text-indigo-600">
                                    {{ aksara.latin }}
                                </p>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
