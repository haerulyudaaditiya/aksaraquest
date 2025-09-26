<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);
const form = useForm({ password: '' });

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-2xl font-extrabold text-slate-900">
                Hapus Akun
            </h2>
            <p class="mt-1 text-slate-600">
                Setelah akun Anda dihapus, semua datanya akan dihapus permanen. Harap unduh data apa pun yang ingin Anda simpan.
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion">Hapus Akun</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6 bg-white rounded-xl">
                <h2 class="text-lg font-bold text-slate-900">
                    Apakah Anda yakin ingin menghapus akun Anda?
                </h2>
                <p class="mt-1 text-sm text-slate-600">
                    Setelah akun Anda dihapus, semua datanya akan dihapus permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi.
                </p>

                <div class="mt-6">
                    <InputLabel for="password" value="Password" class="sr-only" />
                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full border-2 border-slate-800 rounded-xl shadow-[4px_4px_0_#d1d5db] focus:shadow-[4px_4px_0_#4f46e5] transition-all"
                        placeholder="Password"
                        @keyup.enter="deleteUser"
                    />
                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end gap-4">
                    <SecondaryButton @click="closeModal"> Batal </SecondaryButton>
                    <DangerButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Hapus Akun Permanen
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
