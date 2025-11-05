<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    story: Object,
    paragraphs: Object,
});

// Form untuk menambah kata baru
const addWordForm = useForm({
    aksara_word: '',
    latin_word: '',
    paragraph_number: 1,
});

const submitNewWord = () => {
    addWordForm.post(route('admin.stories.content.store', props.story.id), {
        preserveScroll: true,
        onSuccess: () => addWordForm.reset(),
    });
};

// Logika untuk Modal Edit
const editingContent = ref(null);
const editForm = useForm({
    aksara_word: '',
    latin_word: '',
});

const openEditModal = (content) => {
    editingContent.value = content;
    editForm.aksara_word = content.aksara_word;
    editForm.latin_word = content.latin_word;
    editForm.reset(); // Hapus status error/successful sebelumnya
};

const closeEditModal = () => {
    editingContent.value = null;
};

const submitUpdate = () => {
    editForm.put(route('admin.story-contents.update', editingContent.value.id), {
        preserveScroll: true,
        onSuccess: () => {
             // Biarkan modal terbuka sejenak agar "Tersimpan" terlihat
            setTimeout(() => {
                closeEditModal();
            }, 1000);
        },
    });
};

// Logika untuk Modal Hapus
const confirmingDeletion = ref(false);
const itemToDelete = ref(null);

const confirmDeletion = (item) => {
    itemToDelete.value = item;
    confirmingDeletion.value = true;
};

const deleteItem = () => {
    router.delete(route('admin.story-contents.destroy', itemToDelete.value.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    confirmingDeletion.value = false;
    itemToDelete.value = null;
};

const triggerDeleteFromEditModal = () => {
    confirmDeletion(editingContent.value);
    closeEditModal();
};
</script>

<template>
    <Head :title="`Editor Konten: ${story.title}`" />
    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editor Konten: {{ story.title }}
            </h2>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] rounded-2xl p-6 sm:p-8">
                    <h3 class="text-2xl font-extrabold text-slate-900 mb-6 border-b-2 border-slate-800 pb-4">Isi Cerita</h3>
                    <div v-if="Object.keys(paragraphs).length > 0" class="space-y-8">
                        <div v-for="(words, paraNum) in paragraphs" :key="paraNum">
                            <p class="font-bold text-slate-500 uppercase mb-2">Paragraf {{ paraNum }}</p>
                            <div class="flex flex-wrap items-center gap-2">
                                <div v-for="word in words" :key="word.id" class="group relative bg-slate-50 border-2 border-slate-300 rounded-lg p-2">
                                    <p class="font-sunda text-2xl">{{ word.aksara_word }}</p>
                                    <p class="text-xs text-slate-500">{{ word.latin_word }}</p>
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg cursor-pointer" @click="openEditModal(word)">
                                        <span class="font-bold text-white hover:underline">Edit</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div v-else class="text-slate-500 text-center py-8">
                        Belum ada konten untuk dongeng ini. Mulai tambahkan entri di bawah.
                    </div>
                </div>

                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] rounded-2xl p-6 sm:p-8">
                    <h3 class="text-2xl font-extrabold text-slate-900 mb-4">Tambah Entri Baru</h3>
                    <form @submit.prevent="submitNewWord" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
                        <div>
                            <InputLabel for="aksara_word" value="Teks Aksara" class="font-bold" />
                            <TextInput id="aksara_word" v-model="addWordForm.aksara_word" type="text" class="mt-1 block w-full font-sunda" />
                        </div>
                        <div>
                            <InputLabel for="latin_word" value="Teks Latin" class="font-bold" />
                            <TextInput id="latin_word" v-model="addWordForm.latin_word" type="text" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <InputLabel for="paragraph_number" value="Nomor Paragraf" class="font-bold" />
                            <TextInput id="paragraph_number" v-model="addWordForm.paragraph_number" type="number" class="mt-1 block w-full" />
                        </div>
                        <div class="space-y-2">
                            <PrimaryButton :disabled="addWordForm.processing" class="w-full justify-center">Tambah</PrimaryButton>
                            <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                                <p v-if="addWordForm.recentlySuccessful" class="text-sm text-green-600 font-bold text-center sm:text-left">Ditambahkan.</p>
                            </Transition>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <Modal :show="editingContent !== null" @close="closeEditModal">
            <div class="bg-white border-2 border-slate-800 rounded-2xl shadow-[8px_8px_0_#1e293b] p-6 sm:p-8 m-4">
                <h2 class="text-xl font-extrabold text-slate-900 mb-4">Edit Entri</h2>
                <form @submit.prevent="submitUpdate" class="space-y-4">
                    <div>
                        <InputLabel value="Teks Aksara" class="font-bold" />
                        <TextInput v-model="editForm.aksara_word" type="text" class="mt-1 block w-full font-sunda" />
                    </div>
                    <div>
                        <InputLabel value="Teks Latin" class="font-bold" />
                        <TextInput v-model="editForm.latin_word" type="text" class="mt-1 block w-full" />
                    </div>
                    <div class="mt-6 flex justify-between items-center">
                        <DangerButton type="button" @click="triggerDeleteFromEditModal"> Hapus Entri </DangerButton>
                        <div class="flex items-center gap-4">
                            <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                                <p v-if="editForm.recentlySuccessful" class="text-sm text-green-600 font-bold">Tersimpan.</p>
                            </Transition>
                           <SecondaryButton type="button" @click="closeEditModal"> Batal </SecondaryButton>
                           <PrimaryButton :disabled="editForm.processing"> Simpan Perubahan </PrimaryButton>
                        </div>
                    </div>
                </form>
            </div>
        </Modal>

        <Modal :show="confirmingDeletion" @close="closeModal">
            <div class="bg-white border-2 border-slate-800 rounded-2xl shadow-[8px_8px_0_#1e293b] p-6 sm:p-8 m-4">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 bg-red-100 p-3 rounded-xl border-2 border-slate-800">
                        <svg class="h-8 w-8 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-900">Hapus Entri Ini?</h2>
                        <p class="mt-2 text-slate-600">Anda yakin ingin menghapus entri <span class="font-bold font-sunda">{{ itemToDelete?.aksara_word }}</span> secara permanen?</p>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-4">
                    <SecondaryButton @click="closeModal"> Batal </SecondaryButton>
                    <DangerButton @click="deleteItem"> Ya, Hapus Permanen </DangerButton>
                </div>
            </div>
        </Modal>
    </AdminLayout>
</template>
