<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';

defineProps({
    questions: Object,
});

// --- LOGIKA UNTUK MODAL ---
const confirmingDeletion = ref(false);
const itemToDelete = ref(null);

const confirmDeletion = (item) => {
    itemToDelete.value = item;
    confirmingDeletion.value = true;
};

const deleteItem = () => {
    router.delete(route('admin.questions.destroy', itemToDelete.value.id), {
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    confirmingDeletion.value = false;
    itemToDelete.value = null;
};
</script>

<template>
    <Head title="Admin: Kelola Soal" />
    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Panel - Kelola Bank Soal</h2>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-6 text-right">
                    <Link :href="route('admin.questions.create')">
                        <PrimaryButton class="w-full justify-center sm:w-auto">Tambah Soal Baru</PrimaryButton>
                    </Link>
                </div>
                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] rounded-2xl">
                    <div class="p-6 sm:p-8">
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="border-b-2 border-slate-800">
                                    <tr>
                                        <th class="text-left p-3 font-extrabold text-slate-900">Pertanyaan</th>
                                        <th class="text-left p-3 font-extrabold text-slate-900 whitespace-nowrap">Aksara Terkait</th>
                                        <th class="text-left p-3 font-extrabold text-slate-900 whitespace-nowrap">Tipe</th>
                                        <th class="text-left p-3 font-extrabold text-slate-900 whitespace-nowrap">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody v-if="questions.data.length > 0">
                                    <tr v-for="question in questions.data" :key="question.id" class="border-b border-slate-200 hover:bg-slate-50">
                                        <td class="p-3 font-medium min-w-[200px]">{{ question.body }}</td>
                                        <td class="p-3 text-slate-600 font-sunda text-2xl whitespace-nowrap">{{ question.aksara.character }} ({{ question.aksara.latin }})</td>
                                        <td class="p-3 text-sm text-slate-500 whitespace-nowrap">{{ question.type }}</td>
                                        <td class="p-3 whitespace-nowrap">
                                            <div class="flex gap-4">
                                                <Link :href="route('admin.questions.edit', question.id)" class="font-bold text-indigo-600 hover:underline">Edit</Link>
                                                <button @click="confirmDeletion(question)" class="font-bold text-red-600 hover:underline">Hapus</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="4" class="p-6 text-center text-slate-500">
                                            Belum ada data soal.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> <!-- Penutup untuk overflow-x-auto -->
                    </div>

                    <!-- Pagination - Ini sudah responsif -->
                    <div v-if="questions.links.length > 3" class="p-4 border-t-2 border-slate-800 bg-slate-50">
                        <div class="flex flex-wrap -mb-1">
                            <template v-for="(link, key) in questions.links" :key="key">
                                <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded bg-white shadow-sm" v-html="link.label" />
                                <Link v-else class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded bg-white shadow-sm hover:bg-indigo-50 hover:border-indigo-500 hover:text-indigo-700 transition" :class="{ 'bg-indigo-600 text-white hover:bg-indigo-700 hover:text-white': link.active }" :href="link.url" v-html="link.label" />
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>

    <Modal :show="confirmingDeletion" @close="closeModal">
        <div class="bg-white border-2 border-slate-800 rounded-2xl shadow-[8px_8px_0_#1e293b] p-6 sm:p-8 m-4">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 bg-red-100 p-3 rounded-xl border-2 border-slate-800">
                    <svg class="h-8 w-8 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900">
                        Hapus Data Soal?
                    </h2>
                    <p class="mt-2 text-slate-600">
                        Anda yakin ingin menghapus soal <span class="font-bold">"{{ itemToDelete?.body }}"</span>? Tindakan ini akan menghapus data secara permanen.
                    </p>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-4">
                <SecondaryButton @click="closeModal"> Batal </SecondaryButton>
                <DangerButton @click="deleteItem"> Ya, Hapus Permanen </DangerButton>
            </div>
        </div>
    </Modal>
</template>
