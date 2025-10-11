<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    lesson: Object,
    chapters: Array,
    aksaras: Array,
    selectedAksaraIds: Array,
});

const form = useForm({
    title: props.lesson.title,
    order: props.lesson.order,
    chapter_id: props.lesson.chapter_id,
    aksara_ids: props.selectedAksaraIds,
});

const submit = () => {
    form.put(route('admin.lessons.update', props.lesson.id));
};
</script>
<template>
    <Head title="Admin: Edit Pelajaran" />
    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Pelajaran</h2>
        </template>
        <div class="py-12 bg-slate-100">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] sm:rounded-2xl p-6 sm:p-8">
                    <form @submit.prevent="submit" class="max-w-2xl space-y-6">
                        <div>
                            <InputLabel for="chapter_id" value="Pilih Bab" class="font-bold" />
                            <select v-model="form.chapter_id" id="chapter_id" class="mt-1 block w-full border-2 border-slate-800 rounded-xl py-2 px-3 shadow-[4px_4px_0_#d1d5db] focus:shadow-[4px_4px_0_#4f46e5] transition-all">
                                <option v-for="chapter in chapters" :key="chapter.id" :value="chapter.id">{{ chapter.title }}</option>
                            </select>
                            <InputError :message="form.errors.chapter_id" class="mt-2" />
                        </div>
                         <div>
                            <InputLabel for="title" value="Judul Pelajaran" class="font-bold" />
                            <TextInput id="title" v-model="form.title" type="text" class="mt-1 block w-full" />
                            <InputError :message="form.errors.title" class="mt-2" />
                        </div>
                        <div>
                            <InputLabel for="order" value="Urutan Pelajaran" class="font-bold" />
                            <TextInput id="order" v-model="form.order" type="number" class="mt-1 block w-full" />
                            <InputError :message="form.errors.order" class="mt-2" />
                        </div>
                        <div>
                            <InputLabel value="Pilih Aksara untuk Pelajaran Ini" class="font-bold mb-2" />
                            <div class="grid grid-cols-4 gap-4 bg-slate-50 p-4 border-2 border-slate-800 rounded-xl">
                                <label v-for="aksara in aksaras" :key="aksara.id" class="flex items-center gap-2">
                                    <input type="checkbox" :value="aksara.id" v-model="form.aksara_ids" class="rounded text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="font-sunda text-2xl">{{ aksara.character }}</span>
                                    <span class="font-medium">{{ aksara.latin }}</span>
                                </label>
                            </div>
                             <InputError :message="form.errors.aksara_ids" class="mt-2" />
                        </div>
                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">Simpan Perubahan</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
