<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const form = useForm({
    character: '',
    latin: '',
    philosophy: '',
    audio: null, // Properti untuk menampung file audio
});

const submit = () => {
    form.post(route('admin.aksara.store'));
};

const handleFileInput = (event) => {
    if (event.target.files.length > 0) {
        form.audio = event.target.files[0];
    } else {
        form.audio = null;
    }
};
</script>

<template>
    <Head title="Admin: Tambah Aksara" />
    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Aksara Baru
            </h2>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] rounded-2xl p-6 sm:p-8">
                    <form @submit.prevent="submit" class="max-w-2xl space-y-6">
                        <div>
                            <InputLabel for="character" value="Karakter Aksara" class="font-bold" />
                            <TextInput id="character" v-model="form.character" type="text" class="mt-1 block w-full" />
                            <InputError :message="form.errors.character" class="mt-2" />
                        </div>
                        <div>
                            <InputLabel for="latin" value="Nama Latin" class="font-bold" />
                            <TextInput id="latin" v-model="form.latin" type="text" class="mt-1 block w-full" />
                            <InputError :message="form.errors.latin" class="mt-2" />
                        </div>
                        <div>
                            <InputLabel for="philosophy" value="Filosofi & Makna" class="font-bold" />
                            <textarea id="philosophy" v-model="form.philosophy" class="w-full border-2 border-slate-800 rounded-xl py-2 px-3 shadow-[4px_4px_0_#d1d5db] transition-all duration-200 focus:outline-none focus:ring-0 focus:border-indigo-500 focus:shadow-[4px_4px_0_#4f46e5]" rows="5"></textarea>
                            <InputError :message="form.errors.philosophy" class="mt-2" />
                        </div>
                        <div>
                            <InputLabel for="audio" value="File Audio (.mp3)" class="font-bold" />
                            <input id="audio" @input="handleFileInput" type="file" accept=".mp3" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100"/>
                            <InputError :message="form.errors.audio" class="mt-2" />
                        </div>
                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">Simpan Aksara</PrimaryButton>
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
