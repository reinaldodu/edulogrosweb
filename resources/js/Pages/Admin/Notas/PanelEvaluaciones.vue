<template>
    <AppLayout title="Panel de evaluaciones">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">
            <div class="w-full">
                <div class="flex flex-col md:flex-row justify-center mt-4 text-sm">                
                        <!-- Selector periodos -->
                        <label class="label" for="periodo">Periodo:</label>
                        <select class="select select-sm select-bordered mr-4"
                                name="periodo" 
                                id="periodo" 
                                @change="consultarNotas"
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
                                @change="consultarNotas"
                                v-model="data.asignatura_id">
                            <option disabled value="">Seleccione una asignatura</option>
                            <option v-for="(asignatura) in  asignaturas_filtradas"
                                    :key="asignatura.id"
                                    :value="asignatura.id"                                
                            >{{ asignatura.nombre }}</option>
                        </select>
                </div>
                <div>
                    <div v-if="((data.periodo_id)&&(data.grupo_id)&&(data.asignatura_id))">
                        <div v-if="estudiantes && estudiantes.length>0">
                            <div v-if="evaluaciones && evaluaciones.length !==0">
                                <div v-for="(evaluacion,i) in evaluaciones" :key="i">
                                    <!-- Encabezado tipo de evaluación -->
                                    <div class="bg-green-200 rounded-lg shadow-md indent-2">
                                        <p class="text-sm mt-5">
                                            <span class="font-bold">Tipo de evaluación: </span>
                                            <span>{{ evaluacion.tipo_evaluacion.nombre }}</span>
                                        </p>
                                        <p class="text-sm">
                                            <span class="font-bold">Peso evaluación:</span>
                                            <span>{{ evaluacion.porcentaje }}% </span>
                                        </p>
                                    </div>
                                    <!-- SI EL TIPO DE EVALUACIÓN ES LOGROS -->
                                    <div class="mt-2" v-if="evaluacion.tipo_evaluacion_id===id_tipo_logros">
                                        <template v-if="logros.length > 0 ">
                                            <TablaLogros :logros="logros" 
                                                        :evaluacion="evaluacion" 
                                                        :estudiantes="estudiantes" 
                                            />
                                        </template>
                                        <template v-else>
                                            <div class="alert alert-info shadow-lg">
                                                <div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    <span class="text-sm">No hay {{ $page.props.nombre_logros }} registrados para esta asignatura.</span>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                    <!-- SI EL TIPO DE EVALUACIÓN ES EVALUACIÓN GENERAL -->
                                    <div v-else class="mt-2">
                                        <TablaGenerales :evaluacion="evaluacion"
                                                        :actividades="actividades_generales.filter(actividades =>actividades.tipo_evaluacion_id === evaluacion.tipo_evaluacion_id)" 
                                                        :grupo_id="data.grupo_id" 
                                                        :periodo_id="data.periodo_id" 
                                                        :asignatura_id="data.asignatura_id"
                                                        :estudiantes="estudiantes" />
                                    </div>
                                </div>
                            </div>
                            <div v-else-if="evaluaciones" class="flex justify-center m-5">
                                <div class="alert alert-info shadow-lg w-full">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span>Debe crear primero un </span>
                                        <Link class="link" :href="route('admin.sistema-evaluacion.index')">sistema de evaluación!</Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else-if="estudiantes">
                            <div class="alert alert-info shadow-lg w-full mt-5">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current flex-shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="text-sm">No existen estudiantes en este grupo.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import TablaLogros from "@/Pages/Admin/Notas/TablaLogros.vue";
import TablaGenerales from "@/Pages/Admin/Notas/TablaGenerales.vue";
import { Inertia } from "@inertiajs/inertia";
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/inertia-vue3";

const title = ref('Panel de evaluaciones');

const props = defineProps({
    periodos: Array,
    grupos: Array,
    asignaturas: Array,
    logros: Array,
    actividades_generales: Array,
    estudiantes: Array,
    evaluaciones: Array,
    id_tipo_logros: Number,
    selectores: Object,
});

const asignaturas_filtradas = ref(props.asignaturas.filter(asignatura => asignatura.grupo_id === props.selectores.grupo));

const data = ref({    
    periodo_id: props.selectores.periodo ? props.selectores.periodo : usePage().props.value.periodo,
    grupo_id: props.selectores.grupo ? props.selectores.grupo : '',
    asignatura_id: props.selectores.asignatura ? props.selectores.asignatura : '',
});

const cambiaGrupo = () => {
    //filtrar asignaturas por grupo
    asignaturas_filtradas.value = props.asignaturas.filter(asignatura => asignatura.grupo_id === data.value.grupo_id);
    data.value.asignatura_id = '';
}

function consultarNotas()
{
    if (data.value.periodo_id && data.value.grupo_id && data.value.asignatura_id) {
        Inertia.visit(route('admin.panel-evaluaciones.show', { periodo:data.value.periodo_id, grupo:data.value.grupo_id, asignatura:data.value.asignatura_id }),{ preserveState: true, preserveScroll: true });
    }
}

</script>