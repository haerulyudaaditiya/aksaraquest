<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";

defineProps({
    stories: Array,
});

const confirmingDeletion = ref(false);
const itemToDelete = ref(null);

const confirmDeletion = (item) => {
    itemToDelete.value = item;
    confirmingDeletion.value = true;
};

const deleteItem = () => {
    router.delete(route("admin.stories.destroy", itemToDelete.value.id), {
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    confirmingDeletion.value = false;
    itemToDelete.value = null;
};
</script>

<template>
    <Head title="Admin: Kelola Dongeng" />
    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Admin Panel - Kelola Dongeng
            </h2>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-6 text-right">
                    <Link :href="route('admin.stories.create')">
                        <PrimaryButton>Tambah Dongeng Baru</PrimaryButton>
                    </Link>
                </div>
                <div
                    class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] sm:rounded-2xl"
                >
                    <div class="p-6 sm:p-8">
                        <table class="w-full">
                            <thead class="border-b-2 border-slate-800">
                                <tr>
                                    <th
                                        class="text-left p-3 font-extrabold text-slate-900"
                                    >
                                        Judul Dongeng
                                    </th>
                                    <th
                                        class="text-left p-3 font-extrabold text-slate-900"
                                    >
                                        Urutan
                                    </th>
                                    <th
                                        class="text-left p-3 font-extrabold text-slate-900"
                                    >
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="story in stories"
                                    :key="story.id"
                                    class="border-b border-slate-200 hover:bg-slate-50"
                                >
                                    <td class="p-3 font-bold text-lg">
                                        {{ story.title }}
                                    </td>
                                    <td class="p-3 font-bold">
                                        {{ story.order }}
                                    </td>
                                    <td class="p-3 space-x-4">
                                        <Link
                                            :href="
                                                route(
                                                    'admin.stories.content.index',
                                                    story.id
                                                )
                                            "
                                            class="font-bold text-green-600 hover:underline"
                                        >
                                            Konten
                                        </Link>
                                        <Link
                                            :href="
                                                route(
                                                    'admin.stories.edit',
                                                    story.id
                                                )
                                            "
                                            class="font-bold text-indigo-600 hover:underline"
                                            >Edit</Link
                                        >
                                        <button
                                            @click="confirmDeletion(story)"
                                            class="font-bold text-red-600 hover:underline"
                                        >
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

    <Modal :show="confirmingDeletion" @close="closeModal">
        <div
            class="bg-white border-2 border-slate-800 rounded-2xl shadow-[8px_8px_0_#1e293b] p-6 sm:p-8 m-4"
        >
            <h2 class="text-xl font-extrabold text-slate-900">
                Hapus Dongeng?
            </h2>
            <p class="mt-2 text-slate-600">
                Anda yakin ingin menghapus dongeng "{{ itemToDelete?.title }}"?
                Tindakan ini akan menghapus semua konten ceritanya secara
                permanen.
            </p>
            <div class="mt-6 flex justify-end gap-4">
                <SecondaryButton @click="closeModal"> Batal </SecondaryButton>
                <DangerButton @click="deleteItem"> Ya, Hapus </DangerButton>
            </div>
        </div>
    </Modal>
</template>
