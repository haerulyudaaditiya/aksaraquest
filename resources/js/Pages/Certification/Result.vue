<script setup>
import { Head, Link, usePage } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { ref, onMounted } from "vue";
import html2canvas from "html2canvas";

const props = defineProps({
    attempt: Object,
});

const user = usePage().props.auth.user;
const formattedDate = new Date(props.attempt.completed_at).toLocaleDateString("id-ID", {
    day: "numeric",
    month: "long",
    year: "numeric",
});

const certificateElement = ref(null);
const isDownloading = ref(false);
const isVisible = ref(false);

onMounted(() => {
    setTimeout(() => (isVisible.value = true), 200);
});

const downloadCertificate = async () => {
    if (!certificateElement.value) return;
    isDownloading.value = true;

    const canvas = await html2canvas(certificateElement.value, {
        scale: 3,
        useCORS: true,
        backgroundColor: "#FDFBF5",
        windowWidth: 1280,
        windowHeight: 720, // paksa hasil download landscape
    });

    const link = document.createElement("a");
    link.download = `sertifikat-aksaraquest-${user.name.toLowerCase().replace(/ /g, "-")}.png`;
    link.href = canvas.toDataURL("image/png");
    link.click();

    isDownloading.value = false;
};
</script>

<template>
    <Head title="Sertifikat Kelulusan" />

    <div class="min-h-screen bg-slate-200 flex flex-col items-center justify-center px-4 py-8 sm:px-6 text-center">
        <!-- Sertifikat -->
        <div
            ref="certificateElement"
            :class="[
                'w-full bg-[#FDFBF5] rounded-lg shadow-2xl p-6 sm:p-8 relative overflow-hidden transform transition-all duration-700 ease-out',
                isVisible ? 'opacity-100 scale-100' : 'opacity-0 scale-90',
                'max-w-md sm:max-w-xl md:max-w-3xl lg:max-w-4xl certificate-landscape',
            ]"
        >
            <div class="absolute inset-0 border-8 border-amber-800/10 rounded-lg"></div>
            <div class="absolute inset-2 border-2 border-amber-800/20 rounded-lg"></div>

            <div class="relative z-10">
                <p class="text-xs sm:text-sm font-semibold text-amber-800 uppercase tracking-[0.2em]">
                    Sertifikat Penyelesaian
                </p>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-800 mt-3">
                    Master Aksara Sunda
                </h1>
                <p class="mt-4 text-slate-500 text-sm sm:text-base">
                    Sertifikat ini dengan bangga dianugerahkan kepada:
                </p>

                <p
                    class="font-signature text-5xl sm:text-6xl md:text-7xl text-slate-900 my-6 border-b-2 border-slate-200 pb-4 sm:pb-6"
                >
                    {{ user.name }}
                </p>

                <p class="text-slate-500 text-sm sm:text-base max-w-2xl mx-auto">
                    atas dedikasi dan keberhasilannya dalam menyelesaikan seluruh kurikulum dan
                    lulus Ujian Sertifikasi AksaraQuest dengan skor akhir yang memuaskan.
                </p>

                <div
                    class="flex flex-col sm:flex-row justify-between sm:justify-around items-center sm:items-end mt-10 sm:mt-12 gap-6 sm:gap-0"
                >
                    <div class="text-center">
                        <p class="font-bold text-slate-700 text-sm sm:text-base">
                            {{ formattedDate }}
                        </p>
                        <hr class="border-slate-800 mt-2" />
                        <p class="text-xs sm:text-sm text-slate-500">Tanggal Kelulusan</p>
                    </div>

                    <div class="relative">
                        <svg
                            class="h-20 w-20 sm:h-24 sm:w-24 text-red-800 transition-transform duration-500 hover:scale-110"
                            viewBox="0 0 100 100"
                        >
                            <path
                                fill="currentColor"
                                d="M89.7 33.6c-4.9-5.9-10.8-11.8-18.3-14.3-7.5-2.5-16.3-1.6-23.8.3-7.5 1.9-14.7 5.7-21.1 9.3-6.4 3.6-12.7 7.9-16.7 14.3-4 6.4-5.3 14.4-4.2 22.3 1.1 7.9 4.3 15.5 8.8 21.8 4.5 6.3 10.2 11.2 16.8 14.3 6.6 3.1 13.9 4.3 21.3 3.9 7.4-.4 14.6-2.9 20.8-6.1 6.2-3.2 11.4-7.5 15.6-12.2 4.2-4.7 7.4-10.1 9.2-15.8 1.8-5.7 2.2-11.7 1.1-17.5-1.1-5.8-3.7-11.3-7.1-16.1z"
                            />
                        </svg>
                        <ApplicationLogo
                            class="h-8 sm:h-10 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white/80"
                        />
                    </div>

                    <div class="text-center">
                        <p class="font-bold text-slate-700 text-sm sm:text-base">
                            {{ attempt.score }} / 100
                        </p>
                        <hr class="border-slate-800 mt-2" />
                        <p class="text-xs sm:text-sm text-slate-500">Skor Akhir</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol -->
        <div class="mt-8 flex flex-col sm:flex-row items-center gap-4">
            <button
                @click="downloadCertificate"
                :disabled="isDownloading"
                class="uppercase font-bold tracking-wider text-base sm:text-lg text-white bg-indigo-500 border-2 border-slate-800 rounded-xl py-3 px-6 shadow-[4px_4px_0_#1e293b] hover:bg-indigo-600 disabled:bg-gray-400 disabled:shadow-none transition-transform duration-200 active:translate-y-1"
            >
                {{ isDownloading ? "Mengunduh..." : "Unduh Sertifikat" }}
            </button>
            <Link
                :href="route('dashboard')"
                class="font-semibold text-slate-600 hover:text-indigo-600 text-sm sm:text-base"
            >
                &larr; Kembali ke Dashboard
            </Link>
        </div>
    </div>
</template>

<style scoped>
.certificate-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 16px;
}

/* Ukuran asli untuk desktop */
.certificate-content {
    position: relative;
    width: 1000px;
    height: 700px;
    background: white;
    border: 8px solid #1e293b;
    border-radius: 20px;
    overflow: hidden;
}

/* Mobile-first scaling */
@media (max-width: 1024px) {
    .certificate-container {
        overflow-x: auto;
    }

    .certificate-content {
        transform-origin: top left;
        transform: scale(0.65);
        width: 1000px; /* ukuran asli */
        height: 700px;
    }
}

/* Jika di layar yang lebih kecil lagi */
@media (max-width: 640px) {
    .certificate-content {
        transform: scale(0.5);
    }
}
</style>
