<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center justify-center px-4 py-2 bg-white border-2 border-slate-800 rounded-xl font-bold text-sm text-slate-800 uppercase tracking-wider shadow-[4px_4px_0_#d1d5db] hover:bg-slate-50 hover:-translate-y-0.5 active:translate-y-0 active:shadow-[2px_2px_0_#d1d5db] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
    >
        <slot />
    </button>
</template>
