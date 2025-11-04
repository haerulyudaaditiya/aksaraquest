<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { ref } from 'vue';

const props = defineProps({
    question: Object,
    aksaras: Array,
});

const form = useForm({
    aksara_id: props.question.aksara_id,
    body: props.question.body,
    type: props.question.type,
    options: props.question.options,
    correct_answer: props.question.correct_answer,
});

const optionInputs = ref(form.options);

const submit = () => {
    form.put(route('admin.questions.update', props.question.id));
};
</script>
<template>
    <Head title="Admin: Edit Soal" />
    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Soal: {{ question.body.substring(0, 30) }}...</h2>
        </template>
        <div class="py-12 bg-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] rounded-2xl p-6 sm:p-8">
                    <form @submit.prevent="submit" class="max-w-2xl space-y-6">
                        <div>
                            <InputLabel for="aksara_id" value="Aksara Terkait (Jawaban Benar)" class="font-bold" />
                            <select v_model="form.aksara_id" id="aksara_id" class="mt-1 block w-full border-2 border-slate-800 rounded-xl py-2 px-3 shadow-[4px_4px_0_#d1d5db] focus:shadow-[4px_4px_0_#4f46e5] transition-all">
                                <option v-for="aksara in aksaras" :key="aksara.id" :value="aksara.id">{{ aksara.character }} ({{ aksara.latin }})</option>
                            </select>
                            <InputError :message="form.errors.aksara_id" class="mt-2" />
                        </div>
                        <div>
                            <InputLabel for="body" value="Teks Pertanyaan" class="font-bold" />
                            <TextInput id="body" v-model="form.body" type="text" class="mt-1 block w-full" />
                            <InputError :message="form.errors.body" class="mt-2" />
                        </div>
                        <div>
                            <InputLabel for="type" value="Tipe Soal" class="font-bold" />
                            <select v-model="form.type" id="type" class="mt-1 block w-full border-2 border-slate-800 rounded-xl py-2 px-3 shadow-[4px_4px_0_#d1d5db] focus:shadow-[4px_4px_0_#4f46e5] transition-all">
                                <option value="character_to_latin">Tebak Nama dari Karakter</option>
                                <option value="latin_to_character">Tebak Karakter dari Nama</option>
                                <option value="audio_to_latin">Tebak Nama dari Audio</option>
                                <option value="audio_to_character">Tebak Karakter dari Audio</option>
                            </select>
                            <InputError :message="form.errors.type" class="mt-2" />
                        </div>
                        <div>
                            <InputLabel value="Pilihan Jawaban (minimal 4)" class="font-bold mb-2" />
                            <div class="space-y-2">
                                <TextInput v-for="(option, index) in optionInputs" :key="index" v-model="form.options[index]" type="text" class="block w-full" placeholder="Pilihan Jawaban"/>
                            </div>
                            <InputError :message="form.errors.options" class="mt-2" />
                        </div>
                        <div>
                            <InputLabel for="correct_answer" value="Jawaban Benar" class="font-bold" />
                            <TextInput id="correct_answer" v-model="form.correct_answer" type="text" class="mt-1 block w-full" />
                            <InputError :message="form.errors.correct_answer" class="mt-2" />
                        </div>
                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">Simpan Perubahan</PrimaryButton>
                            <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                                <p v-if="form.recentlySuccessful" class="text-sm text-green-600 font-bold">Tersimpan.</p>
                            </Transition>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
