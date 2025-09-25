<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const props = defineProps({
    quiz: Object,
    question: Object,
    totalQuestions: Number,
    answeredCount: Number,
});

const isSubmitting = ref(false);
const selectedAnswer = ref(null);

const playQuestionAudio = () => {
    if (
        props.question &&
        props.question.aksara &&
        props.question.aksara.audio_url
    ) {
        const audio = new Audio(props.question.aksara.audio_url);
        audio.play();
    }
};

const submitAnswer = (option) => {
    isSubmitting.value = true;
    selectedAnswer.value = option;
    setTimeout(() => {
        router.post(
            route("arena.quiz.answer", props.quiz.id),
            {
                question_id: props.question.id,
                user_answer: option,
            },
            {
                preserveState: false,
                preserveScroll: true,
                onSuccess: () => {
                    selectedAnswer.value = null;
                    isSubmitting.value = false;
                },
                onError: () => {
                    isSubmitting.value = false;
                },
            }
        );
    }, 1200);
};

const buttonClass = (option) => {
    if (!isSubmitting.value)
        return "bg-white shadow-[4px_4px_0_#d1d5db] hover:bg-slate-50 active:shadow-[2px_2px_0_#d1d5db] active:translate-y-0.5";
    const isSelected = option === selectedAnswer.value;
    const isCorrect = option === props.question.correct_answer;
    if (isCorrect)
        return "bg-green-400 border-green-600 shadow-[4px_4px_0_#15803d] text-white";
    if (isSelected && !isCorrect)
        return "bg-red-400 border-red-600 shadow-[4px_4px_0_#b91c1c] text-white";
    return "bg-slate-200 border-slate-300 text-slate-400 cursor-not-allowed";
};

const progressPercentage = computed(
    () => ((props.answeredCount + 1) / props.totalQuestions) * 100
);
</script>

<template>
    <Head title="Quiz Berlangsung" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Quiz #{{ quiz.id }}
            </h2>
        </template>
        <div class="py-12 bg-slate-100">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-4">
                    <div
                        class="bg-slate-200 rounded-full h-5 border-2 border-slate-800 shadow-[4px_4px_0_#1e293b]"
                    >
                        <div
                            class="bg-green-500 h-full rounded-full transition-all duration-500"
                            :style="{ width: progressPercentage + '%' }"
                        ></div>
                    </div>
                </div>
                <div
                    class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] sm:rounded-2xl"
                >
                    <div class="p-8">
                        <div v-if="question" class="text-center mb-8">
                            <p class="text-lg text-slate-600 font-bold mb-6">
                                Pertanyaan {{ answeredCount + 1 }} dari
                                {{ totalQuestions }}
                            </p>

                            <div
                                class="h-48 flex items-center justify-center my-4"
                            >
                                <div
                                    v-if="
                                        question.type === 'character_to_latin'
                                    "
                                    class="text-9xl font-bold text-slate-800 font-sunda"
                                >
                                    {{ question.character }}
                                </div>
                                <button
                                    v-if="question.type.startsWith('audio_')"
                                    @click="playQuestionAudio"
                                    class="text-indigo-500 border-4 border-indigo-500 rounded-full p-8 transition hover:bg-indigo-50"
                                >
                                    <svg
                                        class="h-16 w-16"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                    >
                                        <path
                                            d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"
                                        ></path>
                                    </svg>
                                </button>
                                <div
                                    v-if="
                                        question.type === 'latin_to_character'
                                    "
                                    class="text-slate-300"
                                >
                                    <svg
                                        class="h-32 w-32"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z"
                                        />
                                    </svg>
                                </div>
                            </div>

                            <h3 class="text-2xl font-bold text-slate-900">
                                {{ question.body }}
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
                            <button
                                v-for="option in question.options"
                                :key="option"
                                @click="submitAnswer(option)"
                                :disabled="isSubmitting"
                                :class="[
                                    buttonClass(option),
                                    {
                                        'font-sunda text-4xl':
                                            question.type.endsWith(
                                                '_character'
                                            ),
                                    },
                                ]"
                                class="w-full uppercase font-bold tracking-wider text-slate-800 border-2 border-slate-800 rounded-xl p-4 text-center hover:-translate-y-0.5 transition-all duration-150"
                            >
                                {{ option }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
