<template>
    <AppLayout title="Consultar observaciones">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
         <div class="flex justify-end px-10 mt-7">
                    <Link class="btn btn-xs" :href="route('admin.tipo-observaciones.index')">
                        Tipos de observación
                    </Link>
                </div>
        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">
            <div class="w-full">
                <div class="flex flex-col md:flex-row justify-center mt-4 text-sm">                
                        <!-- Selector grados -->
                        <label class="label" for="grado">Grado:</label>
                        <select class="select select-sm select-bordered mr-4"
                                name="grado" 
                                id="grado" 
                                @change="cambiaGrado"
                                v-model="data.grado_id">
                            <option disabled value="">Seleccione un grado</option>
                            <option v-for="(grado) in  grados"
                                    :key="grado.id"
                                    :value="grado.id"                                
                            >{{  grado.nombre }}</option>
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
                <div v-if="(data.grado_id && data.asignatura_id)">
                    <CrearObservaciones :grado="data.grado_id" :asignatura="data.asignatura_id" :tipos="tipos" />
                    <VerObservaciones :observaciones="observaciones" :tipos="tipos" />
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

const title = ref('Consultar Observaciones');
const ocultaAgregarObservacion = ref(false);

provide('ocultaAgregarObservacion', ocultaAgregarObservacion);

const props = defineProps({
    grados: Array,
    asignaturas: Array,    
    tipos: Array,
    observaciones: Object,
});

const asignaturas_filtradas = ref([]);

const data = ref({    
    grado_id: '',
    asignatura_id: '',
});

// Filtrar las asignaturas por grado
const cambiaGrado = () => {
    asignaturas_filtradas.value = props.asignaturas.filter(asignatura => asignatura.asignaciones.find(asignacion => asignacion.grupo.grado_id == data.value.grado_id));
    data.value.asignatura_id = '';
}

function consultarObservaciones()
{
    if (data.value.grado_id && data.value.asignatura_id) {
        ocultaAgregarObservacion.value = false;
        Inertia.visit(route('admin.observaciones.show', { grado:data.value.grado_id, asignatura:data.value.asignatura_id }), { preserveState: true, preserveScroll: true });
    }
}

</script>