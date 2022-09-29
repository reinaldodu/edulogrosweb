<template>
    <div>
        <div>
            <!-- Botón para agregar observaciones a estudiantes -->
            <div class="tooltip tooltip-right" data-tip="Asignar observaciones a estudiantes">
                <button class="btn btn-circle btn-sm m-2" @click="visible = !visible">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /> </svg>
                </button>
            </div>
        </div>        
        <table class="table table-compact table-zebra w-full">
            <thead>
                <tr>
                    <th></th>
                    <th>Estudiantes</th>
                    <th class="w-2/3">Observaciones
                        <!-- Activar edicion de Observaciones -->
                        <div class="tooltip tooltip-right capitalize" :data-tip="[ activarEdicion ? 'Desactivar edición' : 'Activar edición' ]">
                            <button class="btn btn-ghost btn-xs" @click="activarEdicion=!activarEdicion">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="text-sm">
                <tr v-for="(estudiante,indice) in  estudiantes" :key="indice">                            
                    <th>{{ indice+1 }}</th>
                    <td>
                        <div class="flex items-center space-x-3">
                            <div class="avatar">
                                <div class="mask mask-squircle w-12 h-12">
                                    <img :src="estudiante.foto" alt="imagen estudiante" />
                                </div>
                            </div>
                            <div>
                                <div class="font-semibold">{{ estudiante.apellidos + ' ' + estudiante.nombres }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="whitespace-normal">
                        <ul class="list-disc" v-for="observacion in estudiante.observaciones" :key="observacion.id">
                            <li>
                                {{ verObservacion(observacion.id) }}
                                <!-- Botón para eliminar observación -->
                                <div v-if="activarEdicion" class="tooltip tooltip-right" data-tip="Eliminar observación">
                                    <button class="align-middle btn btn-xs btn-ghost" @click="eliminaObservacion(estudiante.id, observacion.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75L14.25 12m0 0l2.25 2.25M14.25 12l2.25-2.25M14.25 12L12 14.25m-2.58 4.92l-6.375-6.375a1.125 1.125 0 010-1.59L9.42 4.83c.211-.211.498-.33.796-.33H19.5a2.25 2.25 0 012.25 2.25v10.5a2.25 2.25 0 01-2.25 2.25h-9.284c-.298 0-.585-.119-.796-.33z" />
                                        </svg>
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>    
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import { inject, ref } from 'vue';

const visible = inject('ocultaAgregarObservaciones');
const activarEdicion = ref(false);

const props = defineProps({
    observaciones: Array,
    estudiantes: Array,
    data: Object,
});

const verObservacion = (id) => {
    return props.observaciones.find(observacion => observacion.id == id).observacion
}

function eliminaObservacion(estudianteId, observacionId)
{
        Inertia.delete(route('admin.observaciones-estudiantes.destroy', { estudiante:estudianteId, observacion:observacionId, periodo:props.data.periodo_id }), { preserveScroll: true });
}

</script>