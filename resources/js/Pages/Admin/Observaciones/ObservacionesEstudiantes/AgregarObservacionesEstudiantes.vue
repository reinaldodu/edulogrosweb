<template>
    <div>
        <form @submit.prevent="form.post(route('admin.observaciones-estudiantes.store'), { onSuccess: () => visible=true })">
            
            <div class="alert alert-info shadow-lg mb-5" v-if="form.hasErrors">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>Debe seleccionar mínimo una observación y un estudiante.</span>
                </div>
            </div>

            <div>
                <!-- Input para buscar observaciones -->
                <input type="text" placeholder="Buscar observación..."
                            class="input input-sm input-bordered w-60 ml-5"
                            v-model="search"
                            @keyup="searchObservation"
                />
                <span class="ml-10 text-sm font-semibold"> Total observaciones seleccionadas: {{ form.observaciones.length }}</span>

                <!-- Tabla de observaciones -->
                <div class="overflow-y-auto block h-64 m-5">
                    <table class="table table-compact table-zebra w-full">
                        <thead class="sticky top-0">
                            <tr>
                                <th class="w-5"></th>
                                <th class="w-5"></th>
                                <th>Observaciones <span class="normal-case">(Seleccione una o varias observaciones)</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(observacion,i) in observaciones_filtradas" :key="i">
                                <td>
                                    <label>
                                        <input type="checkbox" class="checkbox" :value="observacion.id" v-model="checkObservation" />
                                    </label>
                                </td>
                                <td class="font-semibold">{{ i + 1 }}</td>
                                <td class="whitespace-normal">{{ observacion.tipo.abreviatura }} - {{ observacion.observacion }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Tabla de Estudiantes -->
                <div class="m-5">
                    <table class="table table-compact table-zebra w-full">
                        <thead>
                            <tr>
                                <th class="w-5">
                                    <label>
                                        <input type="checkbox" class="checkbox" v-model="checkAll" @change="clickAll" />
                                    </label>
                                </th>
                                <th class="w-5"></th>
                                <th>Estudiantes <span class="normal-case">(Seleccione uno o varios estudiantes)</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(estudiante,j) in estudiantes" :key="j">
                                <td>
                                    <label>
                                        <input type="checkbox" class="checkbox" :value="estudiante.id" v-model="checkStudent" />
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
                <button class="btn btn-outline btn-primary" @click.prevent="visible=true" >Cancelar</button>
            </div>
        </form>        
        </div>
</template>


<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { inject, ref } from "vue";

const title = ref('Agregar Observaciones Estudiantes');

const props = defineProps({
    observaciones: Array,
    estudiantes: Array,
    periodo: Number,
});

const visible = inject('ocultaAgregarObservaciones');

const search = ref('');
const observaciones_filtradas = ref(props.observaciones);

//Arreglo que guarda los ids de las observaciones seleccionados
const checkObservation = ref([]);
//Arreglo que guarda los ids de los estudiantes seleccionados
const checkStudent = ref([]);
//Guarda el estado del checkboxAll true/false
const checkAll = ref(false);

const form = useForm({    
    observaciones: checkObservation,
    estudiantes: checkStudent,
    periodo: props.periodo,
});

const searchObservation = () => {
    //Si el campo de busqueda esta vacio, se muestra todas las observaciones
    if(search.value == ''){
        observaciones_filtradas.value = props.observaciones;
    }else{
        //Si el campo de busqueda tiene texto, se filtran las observaciones
        observaciones_filtradas.value = props.observaciones.filter(observacion => observacion.observacion.toLowerCase().includes(search.value.toLowerCase()));
    }
}

const clickAll = () => {
    //Si checkAll está seleccionado agrega todos los ids de estudiantes al arreglo checkStudent
    if (checkAll.value) {
        checkStudent.value = props.estudiantes.map(estudiante => estudiante.id);
    //Sino checkStudent queda vacio
    } else {
        checkStudent.value=[];
    }
}

</script>