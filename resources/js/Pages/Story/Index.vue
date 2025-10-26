<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';

defineProps({
    stories: Array,
});

// --- Animasi scroll (fade-in + slide-up) ---
onMounted(() => {
    const cards = document.querySelectorAll('.fade-in-up');
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        },
        { threshold: 0.2 }
    );

    cards.forEach((card) => observer.observe(card));
});
</script>

<template>
    <Head title="Perpustakaan Dongeng" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Perpustakaan Dongeng
            </h2>
        </template>

        <div class="py-8 sm:py-12 bg-slate-100 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Judul dan deskripsi -->
                <div class="text-center mb-10 fade-in-up">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900">
                        Jelajahi Dunia Dongeng Sunda
                    </h1>
                    <p class="text-slate-600 mt-3 text-base sm:text-lg max-w-2xl mx-auto">
                        Nikmati kumpulan cerita rakyat Sunda penuh makna dan pelajaran hidup.
                    </p>
                </div>

                <!-- Daftar dongeng -->
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 sm:gap-8"
                >
                    <Link
                        v-for="story in stories"
                        :key="story.id"
                        :href="route('dongeng.show', story.id)"
                        class="fade-in-up group block bg-white border-2 border-slate-800 rounded-2xl overflow-hidden shadow-[6px_6px_0_#1e293b] sm:shadow-[8px_8px_0_#1e293b] hover:shadow-[10px_10px_0_#1e293b] hover:-translate-y-2 transition-all duration-500"
                    >
                        <div class="overflow-hidden">
                            <img
                                :src="story.cover_image_url"
                                alt="Sampul Dongeng"
                                class="w-full h-48 sm:h-56 object-cover transform group-hover:scale-105 transition-transform duration-500"
                            />
                        </div>
                        <div class="p-5 sm:p-6">
                            <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 leading-tight">
                                {{ story.title }}
                            </h3>
                            <p
                                class="mt-2 text-slate-600 text-sm sm:text-base h-20 overflow-hidden leading-relaxed"
                            >
                                {{ story.description }}
                            </p>
                        </div>
                    </Link>
                </div>

                <!-- Jika belum ada cerita -->
                <div
                    v-if="!stories.length"
                    class="text-center text-slate-500 mt-16 fade-in-up"
                >
                    <p class="text-lg">Belum ada dongeng yang tersedia saat ini.</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.fade-in-up {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease;
}
.fade-in-up.show {
    opacity: 1;
    transform: translateY(0);
}
</style>
