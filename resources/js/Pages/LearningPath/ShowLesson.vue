<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { onMounted } from "vue";

defineProps({
    lesson: Object,
});

onMounted(() => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("animate-fade-in-up");
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1 }
    );

    document
        .querySelectorAll(".fade-in-up")
        .forEach((el) => observer.observe(el));
});
</script>

<template>
    <Head :title="lesson.title" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-wrap items-center gap-2 sm:gap-4">
                <Link
                    :href="route('belajar.index')"
                    class="font-medium text-indigo-600 hover:text-indigo-800 transition"
                >
                    Jalur Pembelajaran
                </Link>
                <span class="text-gray-400">/</span>
                <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
                    {{ lesson.title }}
                </h2>
            </div>
        </template>

        <div class="py-10 bg-slate-100 min-h-screen">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="bg-white border-2 border-slate-800 overflow-hidden shadow-[6px_6px_0_#1e293b] rounded-2xl transition-all duration-300 fade-in-up"
                >
                    <div class="p-6 sm:p-10">
                        <h3
                            class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-3 fade-in-up"
                        >
                            Materi Pelajaran
                        </h3>
                        <p
                            class="text-slate-600 mb-8 text-sm sm:text-base fade-in-up"
                        >
                            Pelajari setiap karakter di bawah ini. Klik untuk
                            melihat detail, mendengar suara, dan berlatih
                            menulis.
                        </p>

                        <!-- Grid Aksara -->
                        <div
                            class="grid grid-cols-2 sm:grid-cols-3 gap-4 sm:gap-6 mb-10"
                        >
                            <Link
                                v-for="aksara in lesson.aksaras"
                                :key="aksara.id"
                                :href="route('atlas.show', aksara.id)"
                                class="fade-in-up group bg-white border-2 border-slate-800 rounded-xl p-5 flex flex-col items-center justify-center aspect-square shadow-[4px_4px_0_#1e293b] transition-all duration-300 hover:-translate-y-1 hover:-translate-x-1 hover:shadow-[4px_4px_0_#4f46e5] cursor-pointer"
                            >
                                <p
                                    class="text-5xl sm:text-6xl font-bold text-slate-700 font-sunda transition-colors duration-300 group-hover:text-indigo-600"
                                >
                                    {{ aksara.character }}
                                </p>
                                <p
                                    class="mt-2 text-base sm:text-lg font-medium text-indigo-600"
                                >
                                    {{ aksara.latin }}
                                </p>
                            </Link>
                        </div>

                        <!-- Tombol Mulai Kuis -->
                        <div class="text-center fade-in-up">
                            <Link
                                :href="route('belajar.quiz', lesson.id)"
                                method="post"
                                as="button"
                                class="w-full sm:w-auto uppercase font-bold tracking-wider text-lg sm:text-xl text-white bg-green-500 border-2 border-slate-800 rounded-xl py-3 px-8 shadow-[4px_4px_0_#15803d] hover:bg-green-600 hover:-translate-y-1 active:translate-y-0 active:shadow-[2px_2px_0_#15803d] transition-all duration-200"
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
