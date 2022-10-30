<template>  
<div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">
    <div class="card w-96 bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Agregar estudiantes a {{ grupo.nombre }}</h2>
            
            <div class="flex flex-col items-center">
                <!-- DATOS GENERALES -->
                <div>                
                    <form @submit.prevent="form.post(route('admin.grupos.addstudent', form.id), { onSuccess: () => visible=false })">
                        
                        <div class="alert alert-info shadow-lg" v-if="form.hasErrors">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>No ha seleccionado estudiantes.</span>
                            </div>
                        </div>

                        <div class="overflow-x-auto w-full">
                            <table class="table table-compact w-full">
                                <!-- head -->
                                <thead>
                                <tr>
                                    <th>
                                        <label>
                                            <input type="checkbox" class="checkbox" v-model="checkAll" @change="clickAll" />
                                        </label>
                                    </th>
                                    <th>Apellidos y nombres del estudiante</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <!-- rows -->
                                    <tr v-for="(estudiante,i) in estudiantes" :key="i">
                                        <td>
                                            <label>
                                                <input type="checkbox" class="checkbox" :value="estudiante.id" v-model="checkStudent" />
                                            </label>
                                        </td>
                                        <td>
                                            <div class="flex items-center space-x-3">
                                                <div class="avatar">
                                                    <div class="mask mask-squircle w-12 h-12">
                                                        <img :src="estudiante.foto" alt="imagen estudiante" />
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="font-bold">{{ estudiante.apellidos + ' ' + estudiante.nombres }}</div>
                                                    <div class="text-sm opacity-50">Edad:{{ estudiante.edad }} años</div>
                                                </div>
                                            </div>
                                        </td>                                            
                                    </tr>                                        
                                </tbody>                                        
                            </table>
                            <div>
                                <span class="font-semibold">Total estudiantes...</span>{{ estudiantes.length }}
                            </div>          
                        </div>
                        <div class="flex justify-end space-x-2 mt-2">
                            <button type="submit" class="btn btn-primary" :disabled="form.processing">Agregar</button>
                            <button class="btn btn-outline btn-primary" @click.prevent="visible=false" >Cancelar</button>
                        </div>
                    </form>                
                </div>                  
            </div>        
        </div>
    </div>
</div>
</template>


<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/inertia-vue3';
import { inject, ref } from 'vue';

const props = defineProps( {
    grupo:Object,
    estudiantes:Object, // lista de estudiantes disponibles que pertenecen al mismo grado del curso
});

const title = ref('Agregar estudiantes');
//Arreglo que guarda los ids de los estudiantes seleccionados
const checkStudent = ref([]);
//Guarda el estado del checkboxAll true/false
const checkAll = ref(false);

const visible = inject('verDisponibles');

const form = useForm({    
    id:props.grupo.id,
    estudiante:checkStudent,
});

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