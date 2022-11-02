<template>
    <AppLayout title="Banco de observaciones">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
         <div class="flex justify-end m-5 space-x-3">
            <Link class="btn btn-outline btn-primary btn-xs" :href="route('admin.observaciones-estudiantes.index')">
                Observaciones estudiantes
            </Link>
            <Link class="btn btn-xs" :href="route('admin.tipo-observaciones.index')">
                Tipos de observación
            </Link>
        </div>
        <div class="bg-blue-100 m-5 flex flex-col items-center rounded-md shadow-md p-2">
            <div class="w-full">
                <div class="flex flex-col md:flex-row justify-center mt-4 text-sm">                
                        <!-- Selector grupos -->
                        <label class="label" for="grupo">Grupo:</label>
                        <select class="select select-sm select-bordered mr-4"
                                name="grupo" 
                                id="grupo" 
                                @change="cambiaGrupo"
                                v-model="data.grupo_id">
                            <option disabled value="">Seleccione un grupo</option>
                            <option v-for="(grupo) in  grupos"
                                    :key="grupo.id"
                                    :value="grupo.id"                                
                            >{{  grupo.nombre }}</option>
                        </select>

                        <!-- Selector asignaturas -->
                        <label class="label" for="asignatura">Asignatura:</label>
                        <select class="select select-sm select-bordered"
                                name="asignatura" 
                                id="asignatura"
                                @change="consultarObservaciones"
                                v-model="data.asignatura_id">
                            <option disabled value="">Seleccione una asignatura</option>
                            <option v-for="(asignatura) in  asignaturas_filtradas"
                                    :key="asignatura.id"
                                    :value="asignatura.id"                                
                            >{{  asignatura.nombre }}</option>
                        </select>
                </div>
                <div v-if="(data.grupo_id && data.asignatura_id)">
                    <CrearObservaciones :grupo="data.grupo_id" :asignatura="data.asignatura_id" :tipos="tipos" :observaciones_estudiantes="observaciones_estudiantes" />
                    <VerObservaciones :observaciones="observaciones" :tipos="tipos" :observaciones_estudiantes="observaciones_estudiantes" />
                </div>

            </div>
        </div>
   </AppLayout>
</template>


<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import VerObservaciones from "@/Pages/Admin/Observaciones/VerObservaciones.vue";
import CrearObservaciones from "@/Pages/Admin/Observaciones/CrearObservaciones.vue";

import { Inertia } from "@inertiajs/inertia";
import { Link } from '@inertiajs/inertia-vue3';
import { provide, ref } from "vue";

const title = ref('Banco de Observaciones');
const ocultaAgregarObservacion = ref(false);

provide('ocultaAgregarObservacion', ocultaAgregarObservacion);

const props = defineProps({
    grupos: Array,
    tipos: Array,
    asignaturas:Array,
    observaciones: Array,
    observaciones_estudiantes: Array,
});

const asignaturas_filtradas = ref([]);

const data = ref({    
    grupo_id: '',
    asignatura_id: '',
});

// Filtrar las asignaturas por grupo
const cambiaGrupo = () => {
    asignaturas_filtradas.value = props.asignaturas.filter(asignatura => asignatura.grupo_id == data.value.grupo_id);
    data.value.asignatura_id = '';
}

function consultarObservaciones()
{
    if (data.value.grupo_id && data.value.asignatura_id) {
        ocultaAgregarObservacion.value = false;
        Inertia.visit(route('admin.observaciones.show', { grupo:data.value.grupo_id, asignatura:data.value.asignatura_id }), { preserveState: true, preserveScroll: true });
    }
}

</script>