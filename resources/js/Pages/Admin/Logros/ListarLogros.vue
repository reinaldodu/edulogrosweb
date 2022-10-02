<template>
    <AppLayout :title="'Consultar '+ $page.props.nombre_logros">
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
                                @change="consultarLogros"
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
                                @change="consultarLogros"
                                v-model="data.asignatura_id">
                            <option disabled value="">Seleccione una asignatura</option>
                            <option v-for="(asignatura) in  asignaturas_filtradas"
                                    :key="asignatura.id"
                                    :value="asignatura.id"                                
                            >{{  asignatura.nombre }}</option>
                        </select>
                </div>
                <div v-if="(data.periodo_id && data.grupo_id && data.asignatura_id)">
                    <CrearLogros :periodo="data.periodo_id" :grupo="data.grupo_id" :asignatura="data.asignatura_id" />
                    <VerLogros :logros="logros" />
                </div>
            </div>
        </div>
   </AppLayout>
</template>


<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import VerLogros from "@/Pages/Admin/Logros/VerLogros.vue";
import CrearLogros from "@/Pages/Admin/Logros/CrearLogros.vue";

import { Inertia } from "@inertiajs/inertia";
import { provide, ref } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

const title = ref('Consultar ' + usePage().props.value.nombre_logros);
const ocultaAgregarLogro = ref(false);

provide('ocultaAgregarLogro', ocultaAgregarLogro);

const props = defineProps({
    periodos: Array,
    grupos: Array,
    logros: Array,
    asignaturas: Array,
});

const data = ref({    
    periodo_id: usePage().props.value.periodo,
    grupo_id: '',
    asignatura_id: '',
});

const asignaturas_filtradas = ref([]);

//filtrar asignaturas por grupo
const cambiaGrupo = () => {
    asignaturas_filtradas.value = props.asignaturas.filter(asignatura => asignatura.grupo_id == data.value.grupo_id);
    data.value.asignatura_id = '';
}

function consultarLogros()
{
    if (data.value.periodo_id && data.value.grupo_id && data.value.asignatura_id) {
        ocultaAgregarLogro.value = false;
        Inertia.visit(route('admin.logros.show', { periodo:data.value.periodo_id, grupo:data.value.grupo_id, asignatura:data.value.asignatura_id }), { preserveState: true, preserveScroll: true });
    }
}

</script>