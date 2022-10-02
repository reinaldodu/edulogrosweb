<template>
    <AppLayout title="Observaciones estudiantes">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>         
        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">
            <div v-if="ocultaAgregarObservaciones" class="w-full">
                <div class="flex justify-end space-x-3 m-5">
                    <Link class="btn btn-outline btn-primary btn-xs" :href="route('admin.observaciones.index')">
                        Banco de observaciones
                    </Link>                    
                </div>
                <div class="flex flex-col md:flex-row justify-center mt-4 text-sm">                
                        
                        <!-- Selector periodos -->
                        <label class="label" for="periodo">Periodo:</label>
                        <select class="select select-sm select-bordered mr-4"
                                name="periodo" 
                                id="periodo" 
                                @change="consultarObservaciones"
                                v-model="data.periodo_id">
                            <option disabled value="">Seleccione un periodo</option>
                            <option v-for="(periodo) in  periodos"
                                    :key="periodo.id"
                                    :value="periodo.id"                                
                            >{{  periodo.nombre }}</option>
                        </select>
                    
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
                <div v-if="(data.periodo_id && data.grupo_id && data.asignatura_id && estudiantes && observaciones)">
                    <div v-if="observaciones.length > 0 && estudiantes.length > 0">
                        <VerObservacionesEstudiantes :estudiantes="estudiantes" :observaciones="observaciones" :data="data" />
                    </div>    
                    <div v-else class="m-5">
                        <div v-if="observaciones.length === 0" class="alert alert-info shadow-lg">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Debe crear observaciones para este grupo y asignatura, en el </span> <Link class="link" :href="route('admin.observaciones.index')">
                                    banco de observaciones
                                </Link>
                            </div>
                        </div>
                        <div v-if="estudiantes.length === 0" class="alert alert-info shadow-lg">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>No existen estudiantes en este grupo.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="w-full">
                <AgregarObservacionesEstudiantes :observaciones="observaciones" :estudiantes="estudiantes" :periodo="data.periodo_id" />
            </div>
        </div>
   </AppLayout>
</template>


<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import VerObservacionesEstudiantes from "@/Pages/Admin/Observaciones/ObservacionesEstudiantes/VerObservacionesEstudiantes.vue";
import AgregarObservacionesEstudiantes from "@/Pages/Admin/Observaciones/ObservacionesEstudiantes/AgregarObservacionesEstudiantes.vue";

import { Inertia } from "@inertiajs/inertia";
import { Link, usePage } from '@inertiajs/inertia-vue3';
import { provide, ref } from "vue";

const title = ref('Observaciones Estudiantes');

const props = defineProps({
    grupos: Array,
    periodos: Array,
    observaciones: Array,
    estudiantes: Array,
    asignaturas: Array,
});

const asignaturas_filtradas = ref([]);
const ocultaAgregarObservaciones = ref(true);

provide('ocultaAgregarObservaciones', ocultaAgregarObservaciones);

const data = ref({    
    periodo_id: usePage().props.value.periodo,
    grupo_id: '',
    asignatura_id: '',
});

// Filtrar las asignaturas por grupo
const cambiaGrupo = () => {
    //asignaturas.value = props.grupos.filter(grupo => grupo.id === data.value.grupo_id)[0].asignaturas;
    asignaturas_filtradas.value = props.asignaturas.filter(asignatura => asignatura.grupo_id === data.value.grupo_id);
    data.value.asignatura_id = '';
}

function consultarObservaciones()
{
    if (data.value.periodo_id && data.value.grupo_id && data.value.asignatura_id) {
        ocultaAgregarObservaciones.value = true;
        Inertia.visit(route('admin.observaciones-estudiantes.show', { periodo:data.value.periodo_id, grupo:data.value.grupo_id, asignatura:data.value.asignatura_id }), { preserveState: true, preserveScroll: true });
    }
}

</script>