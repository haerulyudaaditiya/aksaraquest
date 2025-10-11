<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

defineProps({
    aksaras: Array,
});

const confirmingAksaraDeletion = ref(false);
const aksaraToDelete = ref(null);

const confirmAksaraDeletion = (aksara) => {
    aksaraToDelete.value = aksara;
    confirmingAksaraDeletion.value = true;
};

const deleteAksara = () => {
    router.delete(route('admin.aksara.destroy', aksaraToDelete.value.id), {
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    confirmingAksaraDeletion.value = false;
    aksaraToDelete.value = null;
};
</script>

<template>
    <Head title="Admin: Kelola Aksara" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Panel - Kelola Aksara</h2>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6 text-right">
                    <Link :href="route('admin.aksara.create')">
                        <PrimaryButton>Tambah Aksara Baru</PrimaryButton>
                    </Link>
                </div>

                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] sm:rounded-2xl">
                    <div class="p-6 sm:p-8">
                        <table class="w-full">
                            <thead class="border-b-2 border-slate-800">
                                <tr>
                                    <th class="text-left p-3 font-extrabold text-slate-900">Aksara</th>
                                    <th class="text-left p-3 font-extrabold text-slate-900">Latin</th>
                                    <th class="text-left p-3 font-extrabold text-slate-900">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="aksara in aksaras" :key="aksara.id" class="border-b border-slate-200 hover:bg-slate-50">
                                    <td class="p-3 font-sunda text-3xl">{{ aksara.character }}</td>
                                    <td class="p-3 font-bold text-lg capitalize">{{ aksara.latin }}</td>
                                    <td class="p-3 space-x-4">
                                        <Link :href="route('admin.aksara.edit', aksara.id)" class="font-bold text-indigo-600 hover:underline">
                                            Edit
                                        </Link>
                                        <button @click="confirmAksaraDeletion(aksara)" class="font-bold text-red-600 hover:underline">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>

    <Modal :show="confirmingAksaraDeletion" @close="closeModal">
        <div class="p-6 bg-white rounded-xl">
            <h2 class="text-lg font-bold text-slate-900">
                Hapus Aksara "{{ aksaraToDelete?.latin }}"?
            </h2>
            <p class="mt-1 text-sm text-slate-600">
                Tindakan ini tidak dapat diurungkan. Semua data terkait, termasuk soal kuis yang menggunakan aksara ini, mungkin akan mengalami error.
            </p>
            <div class="mt-6 flex justify-end gap-4">
                <SecondaryButton @click="closeModal"> Batal </SecondaryButton>
                <DangerButton @click="deleteAksara"> Ya, Hapus </DangerButton>
            </div>
        </div>
    </Modal>
</template>
