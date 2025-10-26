<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';
import Trophy from '@/Components/Icons/Trophy.vue';

const props = defineProps({
    chapters: Array,
    completedLessonIds: Array,
    allLessonsCompleted: Boolean,
});

const allLessons = computed(() => (props.chapters ? props.chapters.flatMap(chapter => chapter.lessons) : []));
const isLessonCompleted = (lessonId) => props.completedLessonIds.includes(lessonId);

const isLessonUnlocked = (lesson) => {
    // 1. Temukan index pelajaran ini di array global
    const currentIndex = allLessons.value.findIndex(l => l.id === lesson.id);

    // 2. Pelajaran pertama (index 0) selalu terbuka
    if (currentIndex === 0) return true;

    // 3. Cek apakah pelajaran SEBELUMNYA sudah selesai
    const previousLesson = allLessons.value[currentIndex - 1];

    // Jika pelajaran sebelumnya ada DAN sudah selesai, maka ini terbuka
    return previousLesson ? isLessonCompleted(previousLesson.id) : false;
};

const getLessonUrl = (lesson) => route('belajar.lesson.show', lesson.id);

// Fungsi ini memotong judul dengan aman
const getLessonTitle = (title) => {
    if (!title) return '';
    const parts = title.split(':');
    return parts[1] ? parts[1].trim() : title;
};

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
        el.style.animationDelay = `${i * 0.1}s`;
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
    opacity: 0;
}
.animate-fade-in-up {
    animation: fade-in-up 0.6s ease-out forwards;
}
</style>

<template>
    <Head title="Jalur Pembelajaran" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Jalur Pembelajaran</h2>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
                <div v-for="chapter in chapters" :key="chapter.id" class="mb-12">
                    <div class="fade-in-up bg-indigo-500 text-white p-4 rounded-xl border-2 border-slate-800 shadow-[8px_8px_0_#4338ca] mb-8 text-center">
                        <h3 class="text-2xl font-extrabold">{{ chapter.title }}</h3>
                        <p class="opacity-90">{{ chapter.description }}</p>
                    </div>

                    <div class="relative flex flex-col items-center">
                        <div class="absolute top-0 h-full w-1.5 bg-slate-300 border-x-2 border-slate-400 rounded-full"></div>

                        <div v-for="lesson in chapter.lessons" :key="lesson.id" class="fade-in-up relative z-10 w-full mb-12">

                            <Link
                                :href="isLessonUnlocked(lesson) ? getLessonUrl(lesson) : '#'"
                                :as="isLessonUnlocked(lesson) ? 'a' : 'div'"
                                class="w-28 h-28 sm:w-32 sm:h-32 flex flex-col items-center justify-center p-4 border-2 border-slate-800 rounded-full mx-auto transition-all duration-200"
                                :class="{
                                    'bg-white shadow-[8px_8px_0_#d1d5db] hover:bg-slate-50 hover:shadow-[8px_8px_0_#b2b9c7]': isLessonUnlocked(lesson) && !isLessonCompleted(lesson.id),
                                    'bg-green-400 border-green-700 shadow-[8px_8px_0_#15803d] text-white': isLessonCompleted(lesson.id),
                                    'bg-gray-300 text-gray-400 grayscale cursor-not-allowed shadow-[8px_8px_0_#a1a1aa]': !isLessonUnlocked(lesson)
                                }"
                            >
                                <span class="text-xs uppercase font-bold tracking-wider">{{ isLessonCompleted(lesson.id) ? 'Selesai' : (isLessonUnlocked(lesson) ? 'Mulai' : '') }}</span>
                                <p class="text-sm sm:text-lg font-bold text-center leading-tight mt-1">{{ getLessonTitle(lesson.title) }}</p>
                            </Link>
                        </div>
                    </div>
                </div>

                <div v-if="allLessonsCompleted" class="fade-in-up relative z-10 w-full mb-12 text-center">
                    <div class="w-28 h-28 sm:w-32 sm:h-32 flex flex-col items-center justify-center p-4 border-2 border-slate-800 rounded-full mx-auto bg-amber-400 border-amber-700 shadow-[8px_8px_0_#ca8a04] text-white">
                        <Trophy class="h-10 sm:h-12 w-10 sm:w-12" />
                        <p class="text-sm sm:text-lg font-bold text-center leading-tight mt-1">Ujian Akhir</p>
                    </div>
                    <Link :href="route('sertifikasi.start')" method="post" as="button" class="mt-8 uppercase font-bold tracking-wider text-lg sm:text-xl text-white bg-slate-800 border-2 border-slate-800 rounded-xl py-3 px-8 sm:py-4 sm:px-10 shadow-[4px_4px_0_#1e293b] hover:bg-black hover:-translate-y-1">
                        Ambil Ujian Sertifikasi
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
