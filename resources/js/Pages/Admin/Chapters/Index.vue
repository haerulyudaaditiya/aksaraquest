<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';

defineProps({
    chapters: Array,
});

// --- LOGIKA MODAL ---
const confirmingDeletion = ref(false);
const itemToDelete = ref(null);

const confirmDeletion = (item) => {
    itemToDelete.value = item;
    confirmingDeletion.value = true;
};

const deleteItem = () => {
    router.delete(route('admin.chapters.destroy', itemToDelete.value.id), {
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    confirmingDeletion.value = false;
    itemToDelete.value = null;
};
</script>

<template>
    <Head title="Admin: Kelola Bab" />
    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Panel - Kelola Bab</h2>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-6 sm:text-right">
                    <Link :href="route('admin.chapters.create')">
                        <PrimaryButton class="w-full sm:w-auto">Tambah Bab Baru</PrimaryButton>
                    </Link>
                </div>
                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] rounded-2xl">
                    <div class="p-6 sm:p-8">
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="border-b-2 border-slate-800">
                                    <tr>
                                        <th class="text-left p-3 font-extrabold text-slate-900">Urutan</th>
                                        <th class="text-left p-3 font-extrabold text-slate-900">Judul</th>
                                        <!-- Menambahkan 'w-1 whitespace-nowrap' ke kolom 'Aksi' -->
                                        <th class="text-left p-3 font-extrabold text-slate-900 w-1 whitespace-nowrap">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="chapter in chapters" :key="chapter.id" class="border-b border-slate-200 hover:bg-slate-50">
                                        <td class="p-3 font-bold text-lg">{{ chapter.order }}</td>
                                        <td class="p-3 font-bold text-lg">{{ chapter.title }}</td>
                                        <!-- Menambahkan 'whitespace-nowrap' ke sel 'Aksi' -->
                                        <td class="p-3 space-x-4 whitespace-nowrap">
                                            <Link :href="route('admin.chapters.edit', chapter.id)" class="font-bold text-indigo-600 hover:underline">Edit</Link>
                                            <button @click="confirmDeletion(chapter)" class="font-bold text-red-600 hover:underline">Hapus</button>
                                        </td>
                                    </tr>

                                    <!-- Menambahkan state jika tabel kosong -->
                                    <tr v-if="chapters.length === 0">
                                        <td colspan="3" class="p-8 text-center text-slate-500">
                                            Belum ada data bab.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>

    <!-- Modal sudah responsif -->
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
                        Hapus Data Bab?
                    </h2>
                    <p class="mt-2 text-slate-600">
                        Anda yakin ingin menghapus bab <span class="font-bold">"{{ itemToDelete?.title }}"</span>? Tindakan ini akan menghapus semua pelajaran di dalamnya secara permanen.
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
