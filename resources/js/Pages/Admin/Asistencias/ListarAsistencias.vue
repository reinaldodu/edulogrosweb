<template>
    <AppLayout title="Asistencia estudiantes">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        <div class="flex justify-end m-5 space-x-3">            
            <Link class="btn btn-xs" :href="route('admin.tipo-asistencias.index')">
                Tipos de asistencia
            </Link>
        </div>
        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">
            <div class="w-full">
                <div class="flex flex-col md:flex-row justify-center mt-4 text-sm">
                        <!-- Selector periodos -->
                        <label class="label" for="periodo">Periodo:</label>
                        <select class="select select-sm select-bordered mr-4"
                                name="periodo" 
                                id="periodo" 
                                @change="consultarAsistencia"
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
                                @change="consultarAsistencia"
                                v-model="data.asignatura_id">
                            <option disabled value="">Seleccione una asignatura</option>
                            <option v-for="(asignatura) in  asignaturas_filtradas"
                                    :key="asignatura.id"
                                    :value="asignatura.id"                                
                            >{{  asignatura.nombre }}</option>
                        </select>
                </div>                
            </div>            
        </div>
   </AppLayout>
</template>


<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";

import { Inertia } from "@inertiajs/inertia";
import { Link, usePage } from '@inertiajs/inertia-vue3';
import { ref } from "vue";

const title = ref('Asistencia Estudiantes');

const props = defineProps({
    grupos: Array,
    periodos: Array,
    asignaturas: Array,
    hoy: String,
});

const asignaturas_filtradas = ref([]);

const data = ref({    
    periodo_id: usePage().props.value.periodo,
    grupo_id: '',
    asignatura_id: '',
});

// Filtrar las asignaturas por grupo
const cambiaGrupo = () => {
    asignaturas_filtradas.value = props.asignaturas.filter(asignatura => asignatura.grupo_id === data.value.grupo_id);
    data.value.asignatura_id = '';
}

function consultarAsistencia()
{
    if (data.value.periodo_id && data.value.grupo_id && data.value.asignatura_id) {
        const periodoSeleccionado = props.periodos.filter(periodo => periodo.id == data.value.periodo_id)[0];
        const fecha = periodoSeleccionado.fecha_fin < props.hoy ? periodoSeleccionado.fecha_fin : props.hoy;
        Inertia.visit(route('admin.asistencia.show', { periodo:data.value.periodo_id, grupo:data.value.grupo_id, asignatura:data.value.asignatura_id, fecha:fecha }));
    }
}

</script>