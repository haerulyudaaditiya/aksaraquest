<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import SignaturePad from 'signature_pad';

const props = defineProps({
    aksara: Object,
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
        if (signaturePad) {
            signaturePad.clear();
        }
    }
};

const clearCanvas = () => {
    if (signaturePad) {
        signaturePad.clear();
    }
};

onMounted(() => {
    // --- PENYESUAIAN KANVAS DENGAN TEMA BERSIH & CERIA ---
    signaturePad = new SignaturePad(canvas.value, {
        // Latar belakang kanvas putih bersih
        backgroundColor: 'rgb(255, 255, 255)',
        // Warna pena hitam/abu-abu gelap untuk kontras maksimal
        penColor: 'rgb(30, 41, 59)' // slate-800
    });
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);
});

onBeforeUnmount(() => {
    window.removeEventListener('resize', resizeCanvas);
});
</script>

<template>
    <Head :title="`Aksara ${aksara.latin}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <Link :href="route('atlas.index')" class="font-medium text-indigo-600 hover:text-indigo-800 transition">
                    Galeri Aksara
                </Link>
                <span class="text-gray-400">/</span>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
                    {{ aksara.latin }}
                </h2>
            </div>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] sm:rounded-2xl">
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8 items-start">

                        <div class="flex flex-col items-center justify-center bg-slate-50 border-2 border-slate-200 rounded-xl p-12 aspect-square">
                            <p class="text-9xl md:text-[12rem] font-bold text-slate-800">{{ aksara.character }}</p>
                            <div class="relative flex items-center gap-3 mt-4">
                                 <p class="text-4xl font-medium text-indigo-600 capitalize">{{ aksara.latin }}</p>
                                 <button v-if="aksara.audio_url" @click="playAudio" class="text-gray-400 hover:text-indigo-600 transition duration-300" title="Dengarkan Pengucapan">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"></path></svg>
                                 </button>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-8">
                            <div>
                                <h3 class="text-2xl font-extrabold text-slate-900 mb-2">Filosofi & Makna</h3>
                                <p class="text-slate-600 leading-relaxed">{{ aksara.philosophy }}</p>
                            </div>

                            <div>
                                <h3 class="text-2xl font-extrabold text-slate-900 mb-2">Latihan Menulis</h3>
                                <div class="w-full aspect-video border-2 border-slate-800 rounded-xl overflow-hidden bg-white">
                                    <canvas ref="canvas" class="w-full h-full"></canvas>
                                </div>
                                <button @click="clearCanvas" class="mt-4 w-full bg-indigo-500 text-white font-bold py-3 px-4 border-2 border-slate-800 rounded-xl shadow-[4px_4px_0_#1e293b] hover:bg-indigo-600 hover:-translate-y-0.5 active:translate-y-0 active:shadow-[2px_2px_0_#1e293b] transition-all">
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
