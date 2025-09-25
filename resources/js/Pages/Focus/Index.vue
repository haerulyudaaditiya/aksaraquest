<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    masteredAksara: Array,
    weakAksara: Array,
});
</script>

<template>
    <Head title="Fokus Latihan" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Fokus Latihan
            </h2>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] sm:rounded-2xl">
                    <div class="p-6 sm:p-8">

                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 bg-indigo-100 rounded-xl border-2 border-slate-800 flex items-center justify-center">
                                    <svg class="h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 3.104.166-.994.84-.945.84.945.166.994M9.75 3.104C8.25 4.232 5.25 6.25 5.25 9.75c0 4.142 3.358 7.5 7.5 7.5s7.5-3.358 7.5-7.5c0-3.5-3-5.518-4.5-6.646M12 9.75a2.25 2.25 0 0 0-2.25 2.25s.034.422.056.634a2.25 2.25 0 0 0 4.388 0c.022-.212.056-.634.056-.634A2.25 2.25 0 0 0 12 9.75Z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-extrabold text-slate-900">Perlu Dilatih</h3>
                                    <p class="text-slate-600">Fokuskan latihanmu pada aksara-aksara ini untuk penguasaan total.</p>
                                </div>
                            </div>

                            <div v-if="weakAksara.length > 0" class="space-y-4">
                                <div v-for="aksara in weakAksara" :key="aksara.id" class="bg-white border-2 border-slate-800 rounded-xl p-4 flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="text-5xl font-bold text-slate-700 w-16 text-center font-sunda">{{ aksara.character }}</div>
                                        <div>
                                            <p class="text-2xl font-bold text-indigo-600 capitalize">{{ aksara.latin }}</p>
                                            <p class="text-sm text-slate-500">Aksara Ngalagena</p>
                                        </div>
                                    </div>
                                    <Link
                                        :href="route('fokus.startPractice', aksara.id)"
                                        method="post"
                                        as="button"
                                        class="uppercase font-bold tracking-wider text-sm text-white bg-indigo-500 border-2 border-slate-800 rounded-lg py-2 px-4 shadow-[4px_4px_0_#1e293b] hover:bg-indigo-600 hover:-translate-y-0.5 active:translate-y-0 active:shadow-[2px_2px_0_#1e293b] transition-all"
                                    >
                                        Latih
                                    </Link>
                                </div>
                            </div>
                            <div v-else class="bg-green-100 border-2 border-green-800 rounded-xl p-6 text-center">
                                <p class="font-bold text-green-900 text-xl">Luar Biasa!</p>
                                <p class="text-green-800">Anda telah menguasai semua aksara dasar. Teruslah berlatih di Arena untuk mempertahankannya.</p>
                            </div>
                        </div>

                        <hr class="my-8 border-slate-300 border-dashed">

                        <div>
                             <h3 class="text-2xl font-extrabold text-slate-900 mb-4">Sudah Dikuasai</h3>
                             <div v-if="masteredAksara.length > 0" class="flex flex-wrap gap-4">
                                <div v-for="aksara in masteredAksara" :key="aksara.id" class="bg-green-400 text-white border-2 border-green-800 rounded-xl p-4 flex flex-col items-center justify-center w-24 h-24 shadow-[4px_4px_0_#15803d]">
                                    <p class="text-4xl font-bold font-sunda">{{ aksara.character }}</p>
                                    <p class="text-sm font-bold capitalize">{{ aksara.latin }}</p>
                                </div>
                             </div>
                             <div v-else>
                                <p class="text-slate-500">Teruslah berlatih di Arena untuk mulai menguasai aksara!</p>
                             </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
