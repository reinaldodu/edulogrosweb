<template>
    <div class="flex ml-4 mt-4">        
        <!-- Botón para agregar logro -->
        <div v-if="!ocultaAgregarLogro">
            <div class="tooltip tooltip-right" :data-tip="'Agregar ' +  $page.props.singular_logros">
                <button class="btn btn-sm btn-circle mt-2 mr-5" @click="ocultaAgregarLogro=true; form.logro=''; form.errors.logro='';">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /> </svg>
                </button>
            </div>
        </div>
        <!-- Form para guardar logro -->
        <div v-if="ocultaAgregarLogro" class="mt-5">
            <form @submit.prevent="form.post(route('admin.logros.store', { periodo:periodo, grupo:grupo, asignatura:asignatura }), { onSuccess: () => form.logro='' })">
                <input type="text" class="input input-sm w-96 mr-2" 
                                    :class="{ 'input-error':form.errors.logro }"
                                    v-model="form.logro"
                                    maxlength="255"
                                    :placeholder="'Escriba su nuevo ' + $page.props.singular_logros" >
                <div class="badge badge-warning"  v-if="form.errors.logro">{{ form.errors.logro }}</div>
                <button type="submit" class="btn btn-sm mr-2" :disabled="form.processing">Guardar</button>
                <button class="btn btn-sm" @click.prevent="ocultaAgregarLogro=false">Cancelar</button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import { inject } from 'vue';

const props = defineProps({
    periodo: Number,
    grupo: Number,
    asignatura: Number,
});

const ocultaAgregarLogro = inject('ocultaAgregarLogro');

const form = useForm({
    logro: '',
});

</script>