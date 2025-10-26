<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import SignaturePad from 'signature_pad';

const props = defineProps({
    aksara: Object,
    lesson: Object,
});

const playAudio = () => {
    if (props.aksara.audio_url) {
        const audio = new Audio(props.aksara.audio_url);
        audio.play();
    }
};

const canvas = ref(null);
let signaturePad = null;

const resizeCanvas = () => {
    if (canvas.value) {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.value.width = canvas.value.offsetWidth * ratio;
        canvas.value.height = canvas.value.offsetHeight * ratio;
        canvas.value.getContext('2d').scale(ratio, ratio);
        if (signaturePad) signaturePad.clear();
    }
};

const clearCanvas = () => signaturePad?.clear();

onMounted(() => {
    signaturePad = new SignaturePad(canvas.value, {
        backgroundColor: 'rgb(255, 255, 255)',
        penColor: 'rgb(30, 41, 59)', // slate-800
    });
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    // --- Animasi scroll (fade-in-up) ---
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
    document.querySelectorAll('.fade-in-up').forEach((el) => observer.observe(el));
});

onBeforeUnmount(() => {
    window.removeEventListener('resize', resizeCanvas);
});
</script>

<template>
    <Head :title="`Aksara ${aksara.latin}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-sm sm:text-base">
                <Link :href="route('belajar.index')" class="font-medium text-indigo-600 hover:text-indigo-800 transition">
                    Jalur Pembelajaran
                </Link>
                <template v-if="lesson">
                    <span class="text-gray-400">/</span>
                    <Link
                        :href="route('belajar.lesson.show', lesson.id)"
                        class="font-medium text-indigo-600 hover:text-indigo-800 transition"
                    >
                        {{ lesson.title }}
                    </Link>
                </template>
                <span class="text-gray-400">/</span>
                <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight capitalize">
                    {{ aksara.latin }}
                </h2>
            </div>
        </template>

        <div class="py-8 sm:py-12 bg-slate-100">
            <div class="max-w-full sm:max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="fade-in-up bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] rounded-xl sm:rounded-2xl"
                >
                    <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 items-start">

                        <!-- Kartu utama aksara -->
                        <div
                            class="fade-in-up flex flex-col items-center justify-center bg-slate-50 border-2 border-slate-200 rounded-xl p-8 sm:p-12 aspect-square"
                        >
                            <p class="text-8xl sm:text-9xl md:text-[12rem] font-bold text-slate-800 font-sunda">
                                {{ aksara.character }}
                            </p>
                            <div class="relative flex items-center gap-3 mt-4">
                                <p class="text-3xl sm:text-4xl font-medium text-indigo-600 capitalize">
                                    {{ aksara.latin }}
                                </p>
                                <button
                                    v-if="aksara.audio_url"
                                    @click="playAudio"
                                    class="text-gray-400 hover:text-indigo-600 transition duration-300"
                                    title="Dengarkan Pengucapan"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="28"
                                        height="28"
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                    >
                                        <path
                                            d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Penjelasan & latihan -->
                        <div class="flex flex-col space-y-6 sm:space-y-8 fade-in-up">
                            <div>
                                <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 mb-2">Filosofi & Makna</h3>
                                <p class="text-slate-600 leading-relaxed text-sm sm:text-base">
                                    {{ aksara.philosophy }}
                                </p>
                            </div>

                            <div>
                                <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 mb-2">Latihan Menulis</h3>
                                <div
                                    class="w-full aspect-video border-2 border-slate-800 rounded-xl overflow-hidden bg-white fade-in-up"
                                >
                                    <canvas ref="canvas" class="w-full h-full"></canvas>
                                </div>
                                <button
                                    @click="clearCanvas"
                                    class="mt-4 w-full bg-indigo-500 text-white font-bold py-3 px-4 border-2 border-slate-800 rounded-xl shadow-[4px_4px_0_#1e293b] hover:bg-indigo-600 hover:-translate-y-0.5 active:translate-y-0 active:shadow-[2px_2px_0_#1e293b] transition-all"
                                >
                                    Bersihkan Kanvas
                                </button>
                            </div>
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
