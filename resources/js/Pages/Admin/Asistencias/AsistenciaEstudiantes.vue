<template>
    <AppLayout title="Asistencia estudiantes">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        <div class="mt-5 ml-8">
            <span class="font-semibold">Asignatura:</span> {{ data.asignatura.nombre }} -
            <span class="font-semibold">Periodo:</span> {{ data.periodo.nombre }}            
        </div>       
        <div v-if="estudiantes.length > 0">
            <form @submit.prevent="form.post(route('admin.asistencia.store'))">
                
                <div class="alert alert-info shadow-lg mb-5" v-if="form.hasErrors">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Debe seleccionar una fecha.</span>
                    </div>
                </div>
                <!-- Fecha de asistencia -->
                <div class="flex ml-8 items-center">
                    <label class="label font-semibold" for="fecha">Fecha:</label>
                    <input  type="date" name="fecha" id="fecha" 
                        class="input input-bordered input-xs"
                        :min="data.periodo.fecha_inicio" 
                        :max="data.periodo.fecha_fin < hoy ? data.periodo.fecha_fin : hoy"
                        @change="cambiaFecha"
                        v-model="form.fecha" />
                </div>
                <div>
                    <!-- Tabla de Estudiantes -->
                    <div class="m-5">
                        <table class="table table-compact table-zebra w-full">
                            <thead>
                                <tr>
                                    <th class="w-5">
                                    </th>
                                    <th class="w-5"></th>
                                    <th><span class="normal-case">Estudiantes</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(estudiante,j) in estudiantes" :key="j">
                                    <td>                                        
                                        <label :id="'btn' + estudiante.id" class="btn btn-circle text-white text-xs font-bold border-0"
                                            :style="'background-color:' + btnColor[estadoAsistenciaEstudiante[estudiante.id]]"
                                            @click="cambiaEstadoAsistencia(estudiante.id)">
                                            <span>{{ tiposAsistencia[estadoAsistenciaEstudiante[estudiante.id]] }}</span>
                                        </label>
                                    </td>
                                    <td class="font-semibold">{{ j + 1 }}</td>
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
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="space-x-2 m-5">
                    <button type="submit" class="btn btn-primary" :disabled="form.processing">Guardar</button>
                    <Link class="btn btn-outline btn-primary" :href="route('admin.asistencia.index')">Cancelar</Link>
                </div>
            </form>        
        </div>
        <div v-else>
            <div class="flex w-auto alert alert-info shadow-lg m-5">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>No exiten estudiantes en este grupo.</span>
                    <Link class="btn btn-xs normal-case" :href="route('admin.asistencia.index')">Regresar</Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

const props = defineProps({
    estudiantes: Array,
    asistencia: Object,
    tipoAsistencia: Array,
    data: Object,
    hoy: String,
});

// Asistencia de cada estudiante
const estadoAsistenciaEstudiante = ref(props.asistencia);

//Crear objetos con los tipos de asistencia y los colores de los botones
//clave = id del tipo de asistencia, valor = nombre del tipo de asistencia y color del botón
const tiposAsistencia = {};
const btnColor = {};
props.tipoAsistencia.forEach((tipo) => {
    tiposAsistencia[tipo.id] = tipo.nombre;
    btnColor[tipo.id] = tipo.color;
});

// Avanzar al siguiente index del tipo de asistencia (avance circular)
const cambiaEstadoAsistencia = (id) => {
    estadoAsistenciaEstudiante.value[id] =
        estadoAsistenciaEstudiante.value[id] + 1 > props.tipoAsistencia[props.tipoAsistencia.length - 1].id
            ? props.tipoAsistencia[0].id // Si es el último tipo de asistencia, se vuelve al primero
            : estadoAsistenciaEstudiante.value[id] + 1;
};

const title = ref('Asistencia Estudiantes ' + props.data.grupo.nombre);

const form = useForm({    
    asistencias: estadoAsistenciaEstudiante.value,
    asignatura_id: props.data.asignatura.id,
    fecha: props.data.fecha,
    grupo_id: props.data.grupo.id,
});

const cambiaFecha = () => {
    if(props.data.periodo.id && props.data.grupo.id && props.data.asignatura.id && form.fecha) {
        Inertia.visit(route('admin.asistencia.show', { periodo:props.data.periodo.id, grupo:props.data.grupo.id, asignatura:props.data.asignatura.id, fecha:form.fecha }));
    }
}

</script>