<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { onMounted, computed } from "vue";

const props = defineProps({
    quiz: Object,
    score: Number,
    correct: Number,
    total: Number,
    xpGained: Number,
    levelUp: Boolean,
    newLevel: Number,
    certificationAttempt: Object, // Bisa null
});

// --- Logika Judul & Teks Dinamis ---
const pageTitle = computed(() => {
    if (props.quiz.type === "certification") {
        return props.certificationAttempt?.passed
            ? "Selamat, Anda Lulus!"
            : "Ujian Gagal";
    }
    return "Hasil Kuis";
});

const mainHeading = computed(() => {
    if (props.certificationAttempt?.passed) return "SELAMAT, ANDA LULUS!";
    if (
        props.quiz.type === "certification" &&
        !props.certificationAttempt?.passed
    )
        return "UJIAN GAGAL";
    return props.score >= 80 ? "Kerja Bagus!" : "Terus Berlatih!";
});

const subHeading = computed(() => {
    if (props.quiz.type === "certification")
        return "Anda telah menyelesaikan Ujian Sertifikasi.";
    if (props.quiz.type === "lesson")
        return "Pelajaran selesai! Berikut adalah hasilnya.";
    return "Latihanmu telah selesai. Berikut adalah hasilnya.";
});

// --- Logika Tombol Dinamis ---
const primaryActionText = computed(() => {
    if (
        props.quiz.type === "certification" &&
        !props.certificationAttempt?.passed
    )
        return "Coba Ujian Lagi";
    if (props.quiz.type === "lesson") return "Ulangi Pelajaran";
    return "Latihan Lagi";
});

const primaryActionRoute = computed(() => {
    if (
        props.quiz.type === "certification" &&
        !props.certificationAttempt?.passed
    )
        return route("sertifikasi.start");
    if (props.quiz.type === "lesson")
        return route("belajar.quiz", props.quiz.lesson_id);
    if (props.quiz.type === "focus")
        return route("fokus.startPractice", props.quiz.aksara_id);
    return route("arena.start");
});

const secondaryActionText = computed(() => {
    if (props.quiz.type === "certification") return "Lihat Sertifikat"; // Placeholder
    if (props.quiz.type === "lesson") return "Kembali ke Jalur Belajar";
    if (props.quiz.type === "focus") return "Kembali ke Fokus";
    return "Selesai";
});

const secondaryActionRoute = computed(() => {
    if (
        props.quiz.type === "certification" &&
        props.certificationAttempt?.passed
    ) {
        return route("sertifikasi.result.show", props.certificationAttempt.id);
    }
    if (props.quiz.type === "lesson") return route("belajar.index");
    if (props.quiz.type === "focus") return route("fokus.index");
    return route("dashboard");
});

// --- Logika Audio ---
onMounted(() => {
    let soundToPlay = "";
    if (props.quiz.type === "certification") {
        soundToPlay = props.certificationAttempt?.passed ? "win" : "lose";
    } else {
        soundToPlay = props.score >= 80 ? "win" : "lose";
    }
    if (soundToPlay) {
        new Audio(`/audio/${soundToPlay}.mp3`).play();
    }
});
</script>

<template>
    <Head :title="pageTitle" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ pageTitle }}
            </h2>
        </template>
        <div class="py-12 bg-slate-100">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 text-center">
                <div
                    class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] sm:rounded-2xl"
                >
                    <div class="p-8 sm:p-12">
                        <div class="mx-auto w-fit mb-4">
                            <svg
                                class="h-24 w-24"
                                viewBox="0 0 512 512"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M256 32C132.3 32 32 132.3 32 256s100.3 224 224 224 224-100.3 224-224S379.7 32 256 32zm0 416c-106.1 0-192-85.9-192-192S149.9 64 256 64s192 85.9 192 192-85.9 192-192 192z"
                                    :fill="score >= 80 ? '#c7d2fe' : '#fee2e2'"
                                />
                                <path
                                    v-if="score >= 80"
                                    d="M369.3 202.7c-4.9-4.9-12.8-4.9-17.7 0L238.4 315.9c-2.1 2.1-5.6 2.1-7.7 0l-53.3-53.3c-4.9-4.9-12.8-4.9-17.7 0s-4.9 12.8 0 17.7l62.1 62.1c6.8 6.8 17.7 6.8 24.5 0l124-124c4.9-4.9 4.9-12.8 0-17.7z"
                                    :fill="score >= 80 ? '#4f46e5' : '#ef4444'"
                                />
                                <path
                                    v-else
                                    d="M329.3 182.7c-4.9-4.9-12.8-4.9-17.7 0L256 238.3l-55.6-55.6c-4.9-4.9-12.8-4.9-17.7 0s-4.9 12.8 0 17.7L238.3 256l-55.6 55.6c-4.9 4.9-4.9 12.8 0 17.7s12.8 4.9 17.7 0L256 273.7l55.6 55.6c4.9 4.9 12.8 4.9 17.7 0s4.9-12.8 0-17.7L273.7 256l55.6-55.6c4.8-4.9 4.8-12.8-.1-17.7z"
                                    fill="#ef4444"
                                />
                            </svg>
                        </div>

                        <h3 class="text-3xl font-extrabold text-slate-900 mb-2">
                            {{ mainHeading }}
                        </h3>
                        <p class="text-slate-600 mb-6">{{ subHeading }}</p>

                        <div
                            v-if="levelUp"
                            class="my-8 p-4 bg-yellow-100 border-2 border-yellow-300 rounded-xl animate-pulse"
                        >
                            <p class="text-2xl font-extrabold text-yellow-600">
                                ✨ NAIK LEVEL! ✨
                            </p>
                            <p class="mt-1 font-semibold text-yellow-800">
                                Selamat, Anda telah mencapai Level
                                {{ newLevel }}!
                            </p>
                        </div>

                        <div class="my-8">
                            <p
                                class="text-sm font-bold text-slate-500 uppercase"
                            >
                                SKOR AKHIR
                            </p>
                            <div
                                class="text-8xl font-extrabold"
                                :class="
                                    score >= 80
                                        ? 'text-indigo-600'
                                        : 'text-red-500'
                                "
                            >
                                {{ score }}
                            </div>
                            <p
                                v-if="xpGained > 0 && !levelUp"
                                class="mt-2 text-xl font-bold text-yellow-500"
                            >
                                +{{ xpGained }} XP
                            </p>
                            <p
                                class="text-lg font-semibold text-slate-700 mt-2"
                            >
                                Jawaban Benar: {{ correct }} / {{ total }}
                            </p>
                        </div>

                        <div
                            class="mt-10 flex flex-col sm:flex-row-reverse gap-4 justify-center"
                        >
                            <Link
                                v-if="
                                    !(
                                        quiz.type === 'certification' &&
                                        certificationAttempt?.passed
                                    )
                                "
                                :href="primaryActionRoute"
                                method="post"
                                as="button"
                                class="w-full sm:w-auto uppercase font-bold tracking-wider text-lg text-white bg-indigo-500 border-2 border-slate-800 rounded-xl py-3 px-6 shadow-[4px_4px_0_#1e293b] hover:bg-indigo-600 hover:-translate-y-0.5 active:translate-y-0 active:shadow-[2px_2px_0_#1e293b] transition-all"
                            >
                                {{ primaryActionText }}
                            </Link>
                            <Link
                                :href="secondaryActionRoute"
                                as="button"
                                class="w-full sm:w-auto uppercase font-bold tracking-wider text-lg text-slate-800 bg-white border-2 border-slate-800 rounded-xl py-3 px-6 shadow-[4px_4px_0_#d1d5db] hover:bg-slate-50 hover:-translate-y-0.5 active:translate-y-0 active:shadow-[2px_2px_0_#d1d5db] transition-all"
                            >
                                {{ secondaryActionText }}
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
