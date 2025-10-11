<script setup>
import { Head, Link, usePage } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { ref } from "vue";
import html2canvas from "html2canvas";

const props = defineProps({
    attempt: Object,
});

const user = usePage().props.auth.user;
const formattedDate = new Date(props.attempt.completed_at).toLocaleDateString(
    "id-ID",
    {
        day: "numeric",
        month: "long",
        year: "numeric",
    }
);

const certificateElement = ref(null);
const isDownloading = ref(false);

const downloadCertificate = () => {
    if (certificateElement.value) {
        isDownloading.value = true;
        html2canvas(certificateElement.value, {
            scale: 2,
            useCORS: true,
            backgroundColor: null, // Jaga transparansi
        }).then((canvas) => {
            const link = document.createElement("a");
            link.download = `sertifikat-aksaraquest-${user.name
                .toLowerCase()
                .replace(/ /g, "-")}.png`;
            link.href = canvas.toDataURL("image/png");
            link.click();
            isDownloading.value = false;
        });
    }
};
</script>

<template>
    <Head title="Sertifikat Kelulusan" />
    <div
        class="min-h-screen bg-slate-200 flex flex-col items-center justify-center p-4 sm:p-6 text-center"
    >
        <div v-if="attempt.passed">
            <div
                ref="certificateElement"
                class="w-full max-w-4xl bg-[#FDFBF5] rounded-lg shadow-2xl p-8 relative overflow-hidden"
            >
                <div
                    class="absolute inset-0 border-8 border-amber-800/10 rounded-lg"
                ></div>
                <div
                    class="absolute inset-2 border-2 border-amber-800/20 rounded-lg"
                ></div>

                <div class="relative z-10">
                    <p
                        class="text-sm font-semibold text-amber-800 uppercase tracking-[0.2em]"
                    >
                        Sertifikat Penyelesaian
                    </p>
                    <h1 class="text-5xl font-extrabold text-slate-800 mt-4">
                        Master Aksara Sunda
                    </h1>
                    <p class="mt-6 text-slate-500">
                        Sertifikat ini dengan bangga dianugerahkan kepada:
                    </p>

                    <p
                        class="font-signature text-7xl text-slate-900 my-6 border-b-2 border-slate-200 pb-6"
                    >
                        {{ user.name }}
                    </p>

                    <p class="text-slate-500 max-w-2xl mx-auto">
                        atas dedikasi dan keberhasilannya dalam menyelesaikan
                        seluruh kurikulum dan lulus Ujian Sertifikasi
                        AksaraQuest dengan skor akhir yang memuaskan.
                    </p>

                    <div class="flex justify-around items-end mt-12">
                        <div class="text-center">
                            <p class="font-bold text-slate-700">
                                {{ formattedDate }}
                            </p>
                            <hr class="border-slate-800 mt-2" />
                            <p class="text-sm text-slate-500">
                                Tanggal Kelulusan
                            </p>
                        </div>

                        <div class="relative">
                            <svg
                                class="h-28 w-28 text-red-800"
                                viewBox="0 0 100 100"
                            >
                                <path
                                    fill="currentColor"
                                    d="M89.7 33.6c-4.9-5.9-10.8-11.8-18.3-14.3-7.5-2.5-16.3-1.6-23.8.3-7.5 1.9-14.7 5.7-21.1 9.3-6.4 3.6-12.7 7.9-16.7 14.3-4 6.4-5.3 14.4-4.2 22.3 1.1 7.9 4.3 15.5 8.8 21.8 4.5 6.3 10.2 11.2 16.8 14.3 6.6 3.1 13.9 4.3 21.3 3.9 7.4-.4 14.6-2.9 20.8-6.1 6.2-3.2 11.4-7.5 15.6-12.2 4.2-4.7 7.4-10.1 9.2-15.8 1.8-5.7 2.2-11.7 1.1-17.5-1.1-5.8-3.7-11.3-7.1-16.1z"
                                ></path>
                            </svg>
                            <ApplicationLogo
                                class="h-10 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white/80"
                            />
                        </div>

                        <div class="text-center">
                            <p class="font-bold text-slate-700">
                                {{ attempt.score }} / 100
                            </p>
                            <hr class="border-slate-800 mt-2" />
                            <p class="text-sm text-slate-500">Skor Akhir</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-8 flex items-center gap-4">
                <button
                    @click="downloadCertificate"
                    :disabled="isDownloading"
                    class="uppercase font-bold tracking-wider text-lg text-white bg-indigo-500 border-2 border-slate-800 rounded-xl py-3 px-6 shadow-[4px_4px_0_#1e293b] hover:bg-indigo-600 disabled:bg-gray-400 disabled:shadow-none disabled:translate-y-1"
                >
                    {{ isDownloading ? "Mengunduh..." : "Unduh Sertifikat" }}
                </button>
                <Link
                    :href="route('dashboard')"
                    class="font-semibold text-slate-600 hover:text-indigo-600"
                >
                    &larr; Kembali ke Dashboard
                </Link>
            </div>
        </div>

        <div v-else></div>
    </div>
</template>
