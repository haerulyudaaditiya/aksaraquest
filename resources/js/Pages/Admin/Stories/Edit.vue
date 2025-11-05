<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    story: Object,
});

const form = useForm({
    title: props.story.title,
    description: props.story.description,
    order: props.story.order,
    cover_image: null,
});

const handleFileInput = (event) => {
    if (event.target.files.length > 0) {
        form.cover_image = event.target.files[0];
    } else {
        form.cover_image = null;
    }
};

// Gunakan router.post karena method PUT/PATCH tidak bisa handle file upload dengan baik di Inertia
const submit = () => {
    router.post(route('admin.stories.update', props.story.id), {
        _method: 'put',
        title: form.title,
        description: form.description,
        order: form.order,
        cover_image: form.cover_image,
    }, {
        onSuccess: () => form.reset('cover_image'),
    });
};
</script>
<template>
    <Head :title="`Admin: Edit Dongeng`" />
    <AdminLayout>
        <template #header><h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Dongeng: {{ story.title }}</h2></template>
         <div class="py-12 bg-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] rounded-2xl p-6 sm:p-8">
                    <form @submit.prevent="submit" class="max-w-2xl space-y-6">
                        <div>
                            <InputLabel for="title" value="Judul Dongeng" class="font-bold" />
                            <TextInput id="title" v-model="form.title" type="text" class="mt-1 block w-full" />
                            <InputError :message="form.errors.title" class="mt-2" />
                        </div>
                        <div>
                            <InputLabel for="order" value="Urutan" class="font-bold" />
                            <TextInput id="order" v-model="form.order" type="number" class="mt-1 block w-full" />
                            <InputError :message="form.errors.order" class="mt-2" />
                        </div>
                        <div>
                            <InputLabel for="description" value="Deskripsi Singkat" class="font-bold" />
                            <textarea id="description" v-model="form.description" class="w-full border-2 border-slate-800 rounded-xl py-2 px-3 shadow-[4px_4px_0_#d1d5db] transition-all" rows="4"></textarea>
                            <InputError :message="form.errors.description" class="mt-2" />
                        </div>
                        <div>
                            <InputLabel for="cover_image" value="Ganti Gambar Sampul (Opsional)" class="font-bold" />
                            <input id="cover_image" @input="handleFileInput" type="file" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100"/>
                            <InputError :message="form.errors.cover_image" class="mt-2" />
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
