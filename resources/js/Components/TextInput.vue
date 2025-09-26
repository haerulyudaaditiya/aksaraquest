<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="w-full border-2 border-slate-800 rounded-xl py-2 px-3 shadow-[4px_4px_0_#d1d5db] transition-all duration-200 focus:outline-none focus:ring-0 focus:border-indigo-500 focus:shadow-[4px_4px_0_#4f46e5]"
        v-model="model"
        ref="input"
    />
</template>
