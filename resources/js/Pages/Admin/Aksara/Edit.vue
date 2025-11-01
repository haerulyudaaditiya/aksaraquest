<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    aksara: Object,
});

const form = useForm({
    philosophy: props.aksara.philosophy,
});

const submit = () => {
    form.put(route('admin.aksara.update', props.aksara.id));
};
</script>

<template>
    <Head :title="`Edit Aksara: ${aksara.latin}`" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Aksara: <span class="capitalize font-bold">{{ aksara.latin }}</span>
            </h2>
        </template>

        <div class="py-12 bg-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white border-2 border-slate-800 overflow-hidden shadow-[8px_8px_0_#1e293b] rounded-2xl p-6 sm:p-8">
                    <form @submit.prevent="submit" class="max-w-2xl">
                        <div>
                            <InputLabel for="philosophy" value="Filosofi & Makna" class="font-bold mb-1" />
                            <textarea
                                id="philosophy"
                                v-model="form.philosophy"
                                class="w-full border-2 border-slate-800 rounded-xl py-2 px-3 shadow-[4px_4px_0_#d1d5db] transition-all duration-200 focus:outline-none focus:ring-0 focus:border-indigo-500 focus:shadow-[4px_4px_0_#4f46e5]"
                                rows="8"
                            ></textarea>
                        </div>
                        <div class="mt-6 flex items-center gap-4">
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
