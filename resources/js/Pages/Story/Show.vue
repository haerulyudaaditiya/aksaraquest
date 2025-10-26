<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

defineProps({
    story: Object,
    paragraphs: Object,
});

const activeTooltip = ref(null);

const showTooltip = (wordId) => {
    activeTooltip.value = wordId;
};

const hideTooltip = () => {
    activeTooltip.value = null;
};

onMounted(() => {
    if (typeof window !== 'undefined') {
        const elements = document.querySelectorAll('.fade-in-up');
        if (elements.length > 0) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) entry.target.classList.add('show');
                });
            });
            elements.forEach((el) => observer.observe(el));
        }
    }
});
</script>

<template>
    <Head :title="story.title" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-wrap items-center gap-2 sm:gap-4">
                <Link
                    :href="route('dongeng.index')"
                    class="font-medium text-indigo-600 hover:text-indigo-800 transition"
                >
                    Perpustakaan Dongeng
                </Link>
                <span class="text-gray-400">/</span>
                <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
                    {{ story.title }}
                </h2>
            </div>
        </template>

        <div class="py-8 sm:py-12 bg-slate-100 min-h-screen">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white border-2 border-slate-800 overflow-hidden rounded-xl sm:rounded-2xl shadow-[6px_6px_0_#1e293b] sm:shadow-[8px_8px_0_#1e293b] fade-in-up">
                    <div class="p-6 sm:p-10">
                        <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 text-center mb-6 sm:mb-10 leading-snug">
                            {{ story.title }}
                        </h1>

                        <div
                            v-for="(words, paraNum) in paragraphs || []"
                            :key="paraNum"
                            class="fade-in-up text-lg sm:text-2xl font-sunda leading-relaxed sm:leading-loose mb-6 sm:mb-8 text-justify"
                        >
                            <span
                                v-for="word in words"
                                :key="word.id"
                                class="relative inline-block mx-[2px] sm:mx-1 cursor-pointer"
                                @mouseenter="showTooltip(word.id)"
                                @mouseleave="hideTooltip"
                                @click="showTooltip(word.id)"
                            >
                                {{ word.aksara_word }}
                                <Transition
                                    enter-active-class="transition ease-out duration-200"
                                    enter-from-class="transform opacity-0 scale-95"
                                    enter-to-class="transform opacity-100 scale-100"
                                    leave-active-class="transition ease-in duration-150"
                                    leave-from-class="transform opacity-100 scale-100"
                                    leave-to-class="transform opacity-0 scale-95"
                                >
                                    <div
                                        v-if="activeTooltip === word.id"
                                        class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max max-w-[80vw] sm:max-w-xs px-3 py-1 bg-slate-800 text-white text-xs sm:text-sm rounded-md shadow-lg z-50"
                                    >
                                        {{ word.latin_word ?? '' }}
                                    </div>
                                </Transition>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.fade-in-up {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.8s ease;
}
.fade-in-up.show {
    opacity: 1;
    transform: translateY(0);
}
.font-sunda {
    font-family: "Noto Sans Sundanese", sans-serif;
}
</style>
