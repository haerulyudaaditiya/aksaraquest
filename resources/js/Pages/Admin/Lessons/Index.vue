<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';

defineProps({
    lessons: Array,
});

// --- LOGIKA BARU UNTUK MODAL ---
const confirmingDeletion = ref(false);
const itemToDelete = ref(null);

const confirmDeletion = (item) => {
    itemToDelete.value = item;
    confirmingDeletion.value = true;
};

const deleteItem = () => {
    router.delete(route('admin.lessons.destroy', itemToDelete.value.id), {
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    confirmingDeletion.value = false;
    itemToDelete.value = null;
};
</script>

<template>
    <Head title="Admin: Kelola Pelajaran" />
    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Panel - Kelola Pelajaran</h2>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6 text-right">
                    <Link :href="route('admin.lessons.create')">
                        <PrimaryButton>Tambah Pelajaran Baru</PrimaryButton>
                    </Link>
                </div>
                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] sm:rounded-2xl">
                    <div class="p-6 sm:p-8">
                        <table class="w-full">
                            <thead class="border-b-2 border-slate-800">
                                <tr>
                                    <th class="text-left p-3 font-extrabold text-slate-900">Judul Pelajaran</th>
                                    <th class="text-left p-3 font-extrabold text-slate-900">Bab</th>
                                    <th class="text-left p-3 font-extrabold text-slate-900">Urutan</th>
                                    <th class="text-left p-3 font-extrabold text-slate-900">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="lesson in lessons" :key="lesson.id" class="border-b border-slate-200 hover:bg-slate-50">
                                    <td class="p-3 font-bold text-lg">{{ lesson.title }}</td>
                                    <td class="p-3 text-slate-600">{{ lesson.chapter.title }}</td>
                                    <td class="p-3 font-bold">{{ lesson.order }}</td>
                                    <td class="p-3 space-x-4">
                                        <Link :href="route('admin.lessons.edit', lesson.id)" class="font-bold text-indigo-600 hover:underline">Edit</Link>
                                        <button @click="confirmDeletion(lesson)" class="font-bold text-red-600 hover:underline">Hapus</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                        Hapus Data Pelajaran?
                    </h2>
                    <p class="mt-2 text-slate-600">
                        Anda yakin ingin menghapus pelajaran <span class="font-bold">"{{ itemToDelete?.title }}"</span>? Tindakan ini akan menghapus data secara permanen.
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
