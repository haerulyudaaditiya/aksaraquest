<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    lesson: Object,
});
</script>

<template>
    <Head :title="lesson.title" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <Link
                    :href="route('belajar.index')"
                    class="font-medium text-indigo-600 hover:text-indigo-800 transition"
                >
                    Jalur Pembelajaran
                </Link>
                <span class="text-gray-400">/</span>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ lesson.title }}
                </h2>
            </div>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] sm:rounded-2xl"
                >
                    <div class="p-6 sm:p-8">
                        <h3 class="text-3xl font-extrabold text-slate-900 mb-2">
                            Materi Pelajaran
                        </h3>
                        <p class="text-slate-600 mb-8">
                            Pelajari setiap karakter di bawah ini. Klik untuk
                            melihat detail, mendengar suara, dan berlatih
                            menulis.
                        </p>

                        <div class="grid grid-cols-3 gap-5 mb-10">
                            <Link
                                v-for="aksara in lesson.aksaras"
                                :key="aksara.id"
                                :href="route('atlas.show', aksara.id)"
                                class="block bg-white border-2 border-slate-800 rounded-xl p-4 flex flex-col items-center justify-center aspect-square shadow-[4px_4px_0_#1e293b] hover:shadow-[4px_4px_0_#4f46e5] hover:-translate-y-1 hover:-translate-x-1 transition-all duration-200 cursor-pointer group"
                            >
                                <p
                                    class="text-6xl font-bold text-slate-700 transition-colors group-hover:text-indigo-600 font-sunda"
                                >
                                    {{ aksara.character }}
                                </p>
                                <p
                                    class="mt-2 text-lg font-medium text-indigo-600"
                                >
                                    {{ aksara.latin }}
                                </p>
                            </Link>
                        </div>

                        <div class="text-center">
                            <Link
                                :href="route('belajar.quiz', lesson.id)"
                                method="post"
                                as="button"
                                class="w-full max-w-sm uppercase font-bold tracking-wider text-xl text-white bg-green-500 border-2 border-slate-800 rounded-xl py-3 px-8 shadow-[4px_4px_0_#15803d] hover:bg-green-600 hover:-translate-y-1 active:translate-y-0 active:shadow-[2px_2px_0_#15803d] transition-all duration-200"
                            >
                                Selesaikan & Mulai Kuis
                            </Link>
                            <p class="text-sm text-slate-500 mt-4">
                                Selesaikan kuis dengan skor minimal 80 untuk
                                membuka pelajaran berikutnya.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
