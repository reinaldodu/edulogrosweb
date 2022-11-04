<template>
    <div>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span>{{ $page.props.flash.message }}</span>
    </div>
    <div class="flex-none">
        <button class="btn btn-sm btn-circle btn-outline text-white" @click="$page.props.flash.message=null">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/inertia-vue3';
import { onMounted } from 'vue';

//Eliminar el mensaje flash  automáticamente después de un tiempo
onMounted(() => {
    if (usePage().props.value.flash.message) {
        setTimeout(() => {
            usePage().props.value.flash.message = null;
        }, 3000);
    }
});

</script>