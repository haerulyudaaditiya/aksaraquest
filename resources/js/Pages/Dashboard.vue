<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Star from '@/Components/Icons/Star.vue';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] sm:rounded-2xl">
                    <div class="p-6 sm:p-8 text-slate-900">

                        <h3 class="text-3xl font-extrabold mb-2">
                            Wilujeng Sumping, {{ $page.props.auth.user.name }}!
                        </h3>
                        <p class="text-slate-600 text-lg">
                            Senang melihatmu kembali. Lanjutkan petualangan belajarmu!
                        </p>

                        <hr class="my-8 border-slate-300 border-dashed">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-center">
                            <div class="bg-slate-50 border-2 border-slate-800 rounded-xl p-6">
                                <p class="text-sm font-bold text-slate-500 uppercase">Level Saat Ini</p>
                                <div class="flex items-center justify-center gap-2 mt-2">
                                    <svg class="h-8 w-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-4xl font-extrabold text-indigo-600">{{ $page.props.auth.user.level }}</p>
                                </div>
                            </div>

                            <div class="bg-slate-50 border-2 border-slate-800 rounded-xl p-6">
                                <p class="text-sm font-bold text-slate-500 uppercase">Total XP</p>
                                <div class="flex items-center justify-center gap-2 mt-2">
                                   <Star class="h-5 w-5 text-amber-400" />
                                    <p class="text-4xl font-extrabold text-amber-600">{{ $page.props.auth.user.xp }}</p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-8 border-slate-300 border-dashed">

                        <div class="flex flex-col sm:flex-row gap-4">
                             <Link
                                :href="route('atlas.index')"
                                class="w-full text-center uppercase font-bold tracking-wider text-lg text-white bg-indigo-500 border-2 border-slate-800 rounded-xl py-3 px-6 shadow-[4px_4px_0_#1e293b] hover:bg-indigo-600 hover:-translate-y-0.5 active:translate-y-0 active:shadow-[2px_2px_0_#1e293b] transition-all"
                            >
                                Lanjutkan Belajar
                            </Link>
                            <Link
                                :href="route('arena.index')"
                                class="w-full text-center uppercase font-bold tracking-wider text-lg text-slate-800 bg-white border-2 border-slate-800 rounded-xl py-3 px-6 shadow-[4px_4px_0_#d1d5db] hover:bg-slate-50 hover:-translate-y-0.5 active:translate-y-0 active:shadow-[2px_2px_0_#d1d5db] transition-all"
                            >
                                Uji Kemampuan
                            </Link>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
