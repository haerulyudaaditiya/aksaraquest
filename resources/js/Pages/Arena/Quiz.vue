<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    quiz: Object,
    question: Object,
    totalQuestions: Number,
    answeredCount: Number,
});

// State management untuk interaktivitas
const isSubmitting = ref(false);
const selectedAnswer = ref(null);

// Fungsi untuk mengirim jawaban
const submitAnswer = (option) => {
    isSubmitting.value = true;
    selectedAnswer.value = option;

    setTimeout(() => {
        router.post(route('arena.quiz.answer', props.quiz.id), {
            question_id: props.question.id,
            user_answer: option,
        }, {
            preserveState: false,
            preserveScroll: true,
            onSuccess: () => {
                selectedAnswer.value = null;
                isSubmitting.value = false;
            },
            onError: () => {
                isSubmitting.value = false;
            }
        });
    }, 1200); // Durasi feedback sedikit lebih cepat
};

// Fungsi helper untuk menentukan kelas CSS tombol secara dinamis
const buttonClass = (option) => {
    if (!isSubmitting.value) {
        return 'bg-white shadow-[4px_4px_0_#d1d5db] hover:bg-slate-50 active:shadow-[2px_2px_0_#d1d5db] active:translate-y-0.5';
    }

    const isSelected = (option === selectedAnswer.value);
    const isCorrect = (option === props.question.correct_answer);

    if (isCorrect) return 'bg-green-400 border-green-600 shadow-[4px_4px_0_#15803d] text-white';
    if (isSelected && !isCorrect) return 'bg-red-400 border-red-600 shadow-[4px_4px_0_#b91c1c] text-white';

    return 'bg-slate-200 border-slate-300 text-slate-400 cursor-not-allowed';
};

// Menghitung persentase progress bar
const progressPercentage = computed(() => {
    return ((props.answeredCount + 1) / props.totalQuestions) * 100;
});
</script>

<template>
    <Head title="Quiz Berlangsung" />
    <AuthenticatedLayout>
         <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Quiz #{{ quiz.id }}</h2>
        </template>
         <div class="py-12 bg-slate-100">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-4">
                    <div class="bg-slate-200 rounded-full h-5 border-2 border-slate-800 shadow-[4px_4px_0_#1e293b]">
                        <div class="bg-green-500 h-full rounded-full transition-all duration-500" :style="{ width: progressPercentage + '%' }"></div>
                    </div>
                </div>

                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] sm:rounded-2xl">
                     <div class="p-8">
                        <div v-if="question" class="text-center mb-8">
                            <p class="text-lg text-slate-600 font-bold mb-6">Pertanyaan {{ answeredCount + 1 }} dari {{ totalQuestions }}</p>
                            <div class="text-9xl font-bold text-slate-800 my-4">{{ question.character }}</div>
                            <h3 class="text-2xl font-bold text-slate-900">{{ question.body }}</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <button
                                v-for="option in question.options"
                                :key="option"
                                @click="submitAnswer(option)"
                                :disabled="isSubmitting"
                                :class="buttonClass(option)"
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
