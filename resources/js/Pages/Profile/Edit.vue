<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const visible = ref(false);

onMounted(() => {
    setTimeout(() => (visible.value = true), 150);
});
</script>

<template>
    <Head title="Profil" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight text-center sm:text-left"
            >
                Profil Pengguna
            </h2>
        </template>

        <div class="py-8 sm:py-12 bg-slate-100">
            <div
                class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-8 transition-all duration-700"
                :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
            >
                <!-- Informasi Profil -->
                <div
                    class="bg-white border-2 border-slate-800 overflow-hidden shadow-[6px_6px_0_#1e293b] rounded-xl sm:rounded-2xl p-5 sm:p-8 transition-transform duration-300 hover:-translate-y-1"
                >
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="w-full"
                    />
                </div>

                <!-- Ubah Password -->
                <div
                    class="bg-white border-2 border-slate-800 overflow-hidden shadow-[6px_6px_0_#1e293b] rounded-xl sm:rounded-2xl p-5 sm:p-8 transition-transform duration-300 hover:-translate-y-1"
                >
                    <UpdatePasswordForm class="w-full" />
                </div>

                <!-- Hapus Akun -->
                <div
                    class="bg-white border-2 border-slate-800 overflow-hidden shadow-[6px_6px_0_#1e293b] rounded-xl sm:rounded-2xl p-5 sm:p-8 transition-transform duration-300 hover:-translate-y-1"
                >
                    <DeleteUserForm class="w-full" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
