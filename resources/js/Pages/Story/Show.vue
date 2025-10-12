<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

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
</script>

<template>
    <Head :title="story.title" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <Link :href="route('dongeng.index')" class="font-medium text-indigo-600 hover:text-indigo-800 transition">
                    Perpustakaan Dongeng
                </Link>
                <span class="text-gray-400">/</span>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ story.title }}</h2>
            </div>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] sm:rounded-2xl">
                    <div class="p-8 sm:p-12">
                        <h1 class="text-4xl font-extrabold text-slate-900 text-center mb-8">{{ story.title }}</h1>

                        <div v-for="(words, paraNum) in paragraphs" :key="paraNum" class="text-2xl font-sunda leading-loose mb-6 text-justify">
                            <span v-for="word in words" :key="word.id" class="relative inline-block mx-1 cursor-pointer" @mouseenter="showTooltip(word.id)" @mouseleave="hideTooltip">
                                {{ word.aksara_word }}
                                <Transition enter-active-class="transition ease-out duration-200" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                    <div v-if="activeTooltip === word.id" class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max px-3 py-1 bg-slate-800 text-white text-sm rounded-md shadow-lg">
                                        {{ word.latin_word }}
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
