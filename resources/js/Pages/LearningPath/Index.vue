<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import Trophy from '@/Components/Icons/Trophy.vue';

const props = defineProps({
    chapters: Array,
    completedLessonIds: Array,
    allLessonsCompleted: Boolean,
});

const allLessons = computed(() => props.chapters.flatMap(chapter => chapter.lessons));
const isLessonCompleted = (lessonId) => props.completedLessonIds.includes(lessonId);

const isLessonUnlocked = (lesson, index) => {
    if (index === 0) return true; // Pelajaran pertama selalu terbuka
    const previousLesson = allLessons.value[index - 1];
    return previousLesson ? isLessonCompleted(previousLesson.id) : false;
};

const getLessonUrl = (lesson) => route('belajar.lesson.show', lesson.id);
</script>

<template>
    <Head title="Jalur Pembelajaran" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Jalur Pembelajaran</h2>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-md mx-auto sm:px-6 lg:px-8">
                <div v-for="chapter in chapters" :key="chapter.id" class="mb-12">
                    <div class="bg-indigo-500 text-white p-4 rounded-xl border-2 border-slate-800 shadow-[8px_8px_0_#4338ca] mb-8 text-center">
                        <h3 class="text-2xl font-extrabold">{{ chapter.title }}</h3>
                        <p class="opacity-90">{{ chapter.description }}</p>
                    </div>

                    <div class="relative flex flex-col items-center">
                        <div class="absolute top-0 h-full w-1.5 bg-slate-300 border-x-2 border-slate-400 rounded-full"></div>

                        <div v-for="(lesson, index) in chapter.lessons" :key="lesson.id" class="relative z-10 w-full mb-12">
                             <Link
                                :href="isLessonUnlocked(lesson, allLessons.findIndex(l => l.id === lesson.id)) ? getLessonUrl(lesson) : '#'"
                                :as="isLessonUnlocked(lesson, allLessons.findIndex(l => l.id === lesson.id)) ? 'a' : 'div'"
                                class="w-32 h-32 flex flex-col items-center justify-center p-4 border-2 border-slate-800 rounded-full mx-auto transition-all duration-200"
                                :class="{
                                    'bg-white shadow-[8px_8px_0_#d1d5db] hover:bg-slate-50 hover:shadow-[8px_8px_0_#b2b9c7]': isLessonUnlocked(lesson, allLessons.findIndex(l => l.id === lesson.id)) && !isLessonCompleted(lesson.id),
                                    'bg-green-400 border-green-700 shadow-[8px_8px_0_#15803d] text-white': isLessonCompleted(lesson.id),
                                    'bg-gray-300 text-gray-400 grayscale cursor-not-allowed shadow-[8px_8px_0_#a1a1aa]': !isLessonUnlocked(lesson, allLessons.findIndex(l => l.id === lesson.id))
                                }"
                            >
                                <span class="text-xs uppercase font-bold tracking-wider">{{ isLessonCompleted(lesson.id) ? 'Selesai' : (isLessonUnlocked(lesson, allLessons.findIndex(l => l.id === lesson.id)) ? 'Mulai' : '') }}</span>
                                <p class="text-lg font-bold text-center leading-tight mt-1">{{ lesson.title.split(':')[1] }}</p>
                            </Link>
                        </div>
                    </div>
                </div>

                <div v-if="allLessonsCompleted" class="relative z-10 w-full mb-12 text-center">
                    <div class="w-32 h-32 flex flex-col items-center justify-center p-4 border-2 border-slate-800 rounded-full mx-auto bg-amber-400 border-amber-700 shadow-[8px_8px_0_#ca8a04] text-white">
                        <Trophy class="h-12 w-12" />
                        <p class="text-lg font-bold text-center leading-tight mt-1">Ujian Akhir</p>
                    </div>
                    <Link :href="route('sertifikasi.start')" method="post" as="button" class="mt-8 uppercase font-bold tracking-wider text-xl text-white bg-slate-800 border-2 border-slate-800 rounded-xl py-4 px-10 shadow-[4px_4px_0_#1e293b] hover:bg-black hover:-translate-y-1">
                        Ambil Ujian Sertifikasi
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
