<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

// --- Efek Parallax ---
const heroSection = ref(null);
const floatingAksara1 = ref(null);
const floatingAksara2 = ref(null);
const floatingAksara3 = ref(null); // Elemen parallax tambahan

const handleMouseMove = (event) => {
    if (!heroSection.value) return;
    const { clientX, clientY } = event;
    const { offsetWidth, offsetHeight } = heroSection.value;

    // Hitung posisi mouse dari -1 (kiri/atas) hingga 1 (kanan/bawah)
    const xPos = (clientX / offsetWidth - 0.5) * 2;
    const yPos = (clientY / offsetHeight - 0.5) * 2;

    // Gerakkan elemen dengan kecepatan berbeda
    if (floatingAksara1.value) {
        floatingAksara1.value.style.transform = `translate(${xPos * -20}px, ${yPos * -10}px)`;
    }
    if (floatingAksara2.value) {
        floatingAksara2.value.style.transform = `translate(${xPos * 15}px, ${yPos * 12}px)`;
    }
    if (floatingAksara3.value) {
        floatingAksara3.value.style.transform = `translate(${xPos * -8}px, ${yPos * 20}px)`;
    }
};

onMounted(() => window.addEventListener("mousemove", handleMouseMove));
onUnmounted(() => window.removeEventListener("mousemove", handleMouseMove));
</script>

<template>
    <Head title="AksaraQuest – Belajar Aksara Sunda dengan Cara Seru" />

    <div class="min-h-screen bg-gradient-to-b from-indigo-50 to-slate-100 text-slate-800 font-sans antialiased flex flex-col">
        <header class="absolute top-0 left-0 right-0 z-20 p-6 backdrop-blur-sm bg-white/30 border-b border-white/50">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <Link :href="route('dashboard')" class="flex items-center gap-3">
                    <ApplicationLogo class="h-9 w-auto drop-shadow-md" />
                    <span class="font-bold text-2xl tracking-tight text-slate-900">AksaraQuest</span>
                </Link>
                <nav v-if="$page.props.auth.user" class="font-semibold">
                    <Link
                        :href="route('dashboard')"
                        class="text-slate-800 hover:text-indigo-600 transition-colors"
                    >
                        Dashboard
                    </Link>
                </nav>
                <template v-else>
                    <div class="flex items-center space-x-6">
                        <Link
                            v-if="canLogin"
                            :href="route('login')"
                            class="font-semibold text-slate-700 hover:text-indigo-600 transition"
                        >
                            Masuk
                        </Link>
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="inline-block bg-indigo-600 text-white text-sm font-bold tracking-wide uppercase py-3 px-6 rounded-xl shadow-[4px_4px_0_#312e81] hover:bg-indigo-700 hover:-translate-y-1 active:translate-y-0 active:shadow-[2px_2px_0_#312e81] transition-all duration-200"
                        >
                            Daftar Gratis
                        </Link>
                    </div>
                </template>
            </div>
        </header>

        <main
            ref="heroSection"
            class="relative flex flex-col justify-center items-center text-center min-h-screen overflow-hidden px-6"
        >
            <div ref="floatingAksara1" class="absolute top-1/3 left-1/4 text-[8rem] font-sunda text-indigo-200/40 transition-transform duration-500 ease-out select-none">ᮊ</div>
            <div ref="floatingAksara2" class="absolute bottom-1/3 right-1/4 text-[6rem] font-sunda text-emerald-200/40 transition-transform duration-500 ease-out select-none">ᮌ</div>
            <div ref="floatingAksara3" class="absolute top-1/2 right-1/3 text-[7rem] font-sunda text-red-200/40 transition-transform duration-500 ease-out select-none">ᮓ</div>

            <div class="relative z-10 max-w-3xl mx-auto">
                <h1 class="text-5xl sm:text-7xl font-extrabold text-slate-900 leading-tight">
                    Kuasai Aksara Sunda,<br />
                    <span class="text-indigo-600">Buka Jendela Budaya.</span>
                </h1>
                <p class="mt-6 text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto">
                    AksaraQuest adalah cara termudah dan paling menyenangkan untuk belajar membaca dan menulis Aksara Sunda melalui permainan interaktif dan jalur belajar terstruktur.
                </p>

                <div v-if="canRegister" class="mt-10">
                    <Link
                        :href="route('register')"
                        class="inline-block bg-indigo-600 text-white text-lg font-bold tracking-wide uppercase py-4 px-10 rounded-xl shadow-[4px_4px_0_#312e81] hover:bg-indigo-700 hover:-translate-y-1 active:translate-y-0 active:shadow-[2px_2px_0_#312e81] transition-all duration-200"
                    >
                        Mulai Sekarang
                    </Link>
                </div>
            </div>
        </main>

        <section class="bg-white py-20 border-y-2 border-slate-800">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div class="max-w-xl">
                    <span class="text-indigo-600 font-bold uppercase tracking-wider">Misi Kami</span>
                    <h2 class="text-4xl font-extrabold text-slate-900 mt-2 mb-6">Menjembatani Warisan Budaya dengan Generasi Digital</h2>
                    <p class="text-lg text-slate-600 mb-6 leading-relaxed">
                        Di era digital, warisan budaya seperti Aksara Sunda seringkali terancam terlupakan. Metode pembelajaran tradisional terasa kaku, monoton, dan gagal menarik minat generasi baru yang terbiasa dengan interaktivitas.
                    </p>
                    <p class="text-lg text-slate-600 leading-relaxed">
                        AksaraQuest lahir untuk memecahkan masalah ini. Kami percaya bahwa cara terbaik untuk melestarikan budaya adalah dengan membuatnya relevan, menarik, dan mudah diakses. Kami mengubah hafalan yang membosankan menjadi sebuah petualangan gamified yang menantang dan memuaskan.
                    </p>
                </div>

                <div class="bg-indigo-50 rounded-3xl border-2 border-slate-800 shadow-[12px_12px_0_#1e293b] p-4 -rotate-2 transform transition-all hover:rotate-0">
                    <div class="bg-white rounded-xl border-2 border-slate-800 overflow-hidden">
                        <div class="p-3 bg-slate-100 border-b-2 border-slate-800 flex items-center gap-2">
                            <span class="h-3 w-3 bg-red-400 rounded-full block border border-red-600"></span>
                            <span class="h-3 w-3 bg-yellow-400 rounded-full block border border-yellow-600"></span>
                            <span class="h-3 w-3 bg-green-400 rounded-full block border border-green-600"></span>
                        </div>

                        <div class="p-6 h-96 relative flex flex-col items-center overflow-hidden">
                            <div class="absolute top-0 h-full w-1.5 bg-slate-300 border-x-2 border-slate-400 rounded-full"></div>

                            <div class="relative z-10 w-28 h-28 flex flex-col items-center justify-center p-2 border-2 border-green-700 rounded-full bg-green-400 shadow-[4px_4px_0_#15803d]">
                                <div class="font-sunda text-3xl text-green-800">ᮊ ᮌ ᮍ</div>
                                <p class="text-xs font-bold text-green-900 text-center leading-tight">Dasar 1</p>
                                <div class="absolute -bottom-2 -right-2 bg-white p-1 rounded-full border-2 border-green-700">
                                    <svg class="h-4 w-4 text-green-700" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" /></svg>
                                </div>
                            </div>

                            <div class="h-10 w-1.5 z-10"></div>

                            <div class="relative z-10 w-28 h-28 flex flex-col items-center justify-center p-2 border-2 border-slate-800 rounded-full bg-white shadow-[4px_4px_0_#d1d5db]">
                                <div class="font-sunda text-3xl text-slate-700">ᮎ ᮏ ᮑ</div>
                                <p class="text-xs font-bold text-slate-800 text-center leading-tight">Dasar 2</p>
                            </div>

                            <div class="h-10 w-1.5 z-10"></div>

                            <div class="relative z-10 w-28 h-28 flex flex-col items-center justify-center p-2 border-2 border-slate-800 rounded-full bg-gray-300 shadow-[4px_4px_0_#a1a1aa] grayscale">
                                <div class="font-sunda text-3xl text-gray-500">ᮒ ᮓ ᮔ</div>
                                <p class="text-xs font-bold text-gray-600 text-center leading-tight">Dasar 3</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="bg-slate-100 py-20">
            <div class="max-w-7xl mx-auto px-6">
                 <div class="max-w-2xl mx-auto text-center mb-16">
                    <h2 class="text-4xl font-extrabold text-slate-900">Platform Belajar Terlengkap</h2>
                    <p class="mt-4 text-lg text-slate-600">
                        Dirancang dengan fitur-fitur canggih untuk membuat proses belajar menjadi efektif dan menyenangkan.
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div class="group flex flex-col items-center p-8 rounded-2xl border-2 border-slate-800 shadow-[8px_8px_0_#d1d5db] hover:-translate-y-1 hover:shadow-[10px_10px_0_#d1d5db] transition-all bg-white">
                        <div class="bg-indigo-100 text-indigo-800 font-bold text-2xl h-16 w-16 flex items-center justify-center rounded-full border-2 border-slate-800 mb-4">
                            1
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-900 mb-2">
                            Belajar Terstruktur
                        </h3>
                        <p class="text-slate-600 leading-relaxed">
                            Ikuti jalur pembelajaran yang terpandu dari dasar hingga mahir, bab per bab.
                        </p>
                    </div>
                    <div class="group flex flex-col items-center p-8 rounded-2xl border-2 border-slate-800 shadow-[8px_8px_0_#d1d5db] hover:-translate-y-1 hover:shadow-[10px_10px_0_#d1d5db] transition-all bg-white">
                        <div class="bg-indigo-100 text-indigo-800 font-bold text-2xl h-16 w-16 flex items-center justify-center rounded-full border-2 border-slate-800 mb-4">
                            2
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-900 mb-2">
                            Arena Interaktif
                        </h3>
                        <p class="text-slate-600 leading-relaxed">
                            Uji kemampuanmu melalui 4 tipe soal berbeda dan sistem kuis adaptif yang cerdas.
                        </p>
                    </div>
                    <div class="group flex flex-col items-center p-8 rounded-2xl border-2 border-slate-800 shadow-[8px_8px_0_#d1d5db] hover:-translate-y-1 hover:shadow-[10px_10px_0_#d1d5db] transition-all bg-white">
                        <div class="bg-indigo-100 text-indigo-800 font-bold text-2xl h-16 w-16 flex items-center justify-center rounded-full border-2 border-slate-800 mb-4">
                            3
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-900 mb-2">
                            Raih Prestasi
                        </h3>
                        <p class="text-slate-600 leading-relaxed">
                            Kumpulkan XP, naik level, dapatkan lencana, dan raih sertifikat digital "Master Aksara".
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-center border-t-2 border-slate-800">
            <div class="max-w-3xl mx-auto px-6">
                <h2 class="text-4xl font-extrabold mb-4">Siap Menjadi Ahli Aksara Sunda?</h2>
                <p class="text-lg text-indigo-100 mb-10">
                    Bergabunglah sekarang dan temukan pengalaman belajar bahasa dan budaya Sunda yang tak terlupakan.
                </p>
                <Link
                    :href="route('register')"
                    class="inline-block bg-white text-indigo-700 text-lg font-bold tracking-wide uppercase py-4 px-10 rounded-xl shadow-[4px_4px_0_#312e81] hover:bg-slate-100 hover:-translate-y-1 active:translate-y-0 active:shadow-[2px_2px_0_#312e81] transition-all duration-200"
                >
                    Daftar Sekarang
                </Link>
            </div>
        </section>

        <footer class="bg-white py-8 text-center border-t-2 border-slate-800">
            <p class="text-slate-500 text-sm">
                © {{ new Date().getFullYear() }} AksaraQuest. Dibuat dengan oleh Haerul Yuda Aditiya.
            </p>
        </footer>
    </div>
</template>
