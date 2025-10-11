<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

// --- Logika untuk Efek Parallax ---
const heroSection = ref(null);
const floatingAksara1 = ref(null);
const floatingAksara2 = ref(null);

const handleMouseMove = (event) => {
    if (!heroSection.value) return;
    const { clientX, clientY } = event;
    const { offsetWidth, offsetHeight } = heroSection.value;

    // Hitung posisi mouse dari -1 (kiri/atas) hingga 1 (kanan/bawah)
    const xPos = (clientX / offsetWidth - 0.5) * 2;
    const yPos = (clientY / offsetHeight - 0.5) * 2;

    // Gerakkan elemen dengan kecepatan berbeda
    if (floatingAksara1.value) {
        floatingAksara1.value.style.transform = `translate(${xPos * -15}px, ${
            yPos * -10
        }px)`;
    }
    if (floatingAksara2.value) {
        floatingAksara2.value.style.transform = `translate(${xPos * 10}px, ${
            yPos * 15
        }px)`;
    }
};

onMounted(() => {
    window.addEventListener("mousemove", handleMouseMove);
});
onUnmounted(() => {
    window.removeEventListener("mousemove", handleMouseMove);
});
</script>

<template>
    <Head title="Selamat Datang di AksaraQuest" />

    <div class="antialiased bg-slate-100 text-slate-800">
        <header class="absolute top-0 left-0 right-0 z-20 p-6">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <Link
                    :href="route('dashboard')"
                    class="flex items-center gap-3"
                >
                    <ApplicationLogo class="h-8 w-auto" />
                    <span class="font-bold text-xl text-slate-800"
                        >AksaraQuest</span
                    >
                </Link>
                <div v-if="$page.props.auth.user" class="font-semibold">
                    <Link
                        :href="route('dashboard')"
                        class="text-slate-800 hover:text-indigo-600"
                        >Dashboard</Link
                    >
                </div>
                <template v-else>
                    <div>
                        <Link
                            v-if="canLogin"
                            :href="route('login')"
                            class="font-bold text-slate-800 hover:text-indigo-600"
                            >Log in</Link
                        >
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="ml-6 inline-block text-white bg-indigo-500 border-2 border-slate-800 rounded-lg py-2 px-5 shadow-[4px_4px_0_#1e293b] hover:bg-indigo-600 hover:-translate-y-0.5 transition-all"
                            >Register</Link
                        >
                    </div>
                </template>
            </div>
        </header>

        <main
            ref="heroSection"
            class="relative min-h-screen flex flex-col items-center justify-center text-center overflow-hidden"
        >
            <div
                ref="floatingAksara1"
                class="absolute top-1/4 left-1/4 text-9xl font-sunda text-indigo-200/50 transition-transform duration-500 ease-out"
            >
                ᮊ
            </div>
            <div
                ref="floatingAksara2"
                class="absolute bottom-1/4 right-1/4 text-8xl font-sunda text-green-200/50 transition-transform duration-500 ease-out"
            >
                ᮌ
            </div>

            <div class="relative z-10 max-w-4xl mx-auto p-6 lg:p-8">
                <h1
                    class="text-5xl sm:text-7xl font-extrabold text-slate-900 leading-tight"
                >
                    Kuasai Aksara Sunda, Buka Jendela Budaya.
                </h1>
                <p class="mt-6 text-lg text-slate-600 max-w-2xl mx-auto">
                    AksaraQuest adalah cara termudah dan paling menyenangkan
                    untuk belajar membaca dan menulis Aksara Sunda melalui
                    permainan interaktif dan jalur belajar terstruktur.
                </p>
                <div v-if="canRegister" class="mt-10">
                    <Link
                        :href="route('register')"
                        class="inline-block w-full max-w-xs uppercase font-bold tracking-wider text-xl text-white bg-indigo-500 border-2 border-slate-800 rounded-xl py-4 px-8 shadow-[4px_4px_0_#1e293b] hover:bg-indigo-600 hover:-translate-y-1 active:translate-y-0 active:shadow-[2px_2px_0_#1e293b] transition-all duration-200"
                    >
                        Mulai Belajar Gratis
                    </Link>
                </div>
            </div>
        </main>

        <section class="bg-white py-12 sm:py-20 border-y-2 border-slate-800">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
                    <div class="flex flex-col items-center">
                        <div
                            class="bg-slate-200 rounded-full h-16 w-16 flex items-center justify-center font-bold text-2xl text-slate-800 border-2 border-slate-800 mb-4"
                        >
                            1
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-900">
                            Belajar Terstruktur
                        </h3>
                        <p class="mt-2 text-slate-600">
                            Ikuti jalur pembelajaran dari dasar hingga mahir,
                            bab per bab, pelajaran per pelajaran.
                        </p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div
                            class="bg-slate-200 rounded-full h-16 w-16 flex items-center justify-center font-bold text-2xl text-slate-800 border-2 border-slate-800 mb-4"
                        >
                            2
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-900">
                            Berlatih di Arena
                        </h3>
                        <p class="mt-2 text-slate-600">
                            Uji kemampuanmu dengan 4 tipe soal berbeda dan
                            sistem kuis adaptif yang cerdas.
                        </p>
                    </div>
                    <div class="flex flex-col items-center">
                        <div
                            class="bg-slate-200 rounded-full h-16 w-16 flex items-center justify-center font-bold text-2xl text-slate-800 border-2 border-slate-800 mb-4"
                        >
                            3
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-900">
                            Raih Prestasi
                        </h3>
                        <p class="mt-2 text-slate-600">
                            Kumpulkan XP, naikkan level, dan dapatkan lencana
                            prestasi untuk setiap pencapaianmu.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-slate-100 py-12 sm:py-20"></section>

        <footer class="bg-white py-8 text-center border-t-2 border-slate-800">
            <p class="text-slate-500">Dibuat oleh Haerul Yuda Aditiya.</p>
        </footer>
    </div>
</template>
