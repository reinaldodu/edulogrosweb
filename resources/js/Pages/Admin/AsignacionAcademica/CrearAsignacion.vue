<template>
    <AppLayout title="Crear Asignaciones">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">
            <div class="card w-xs bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Crear asignación académica</h2>        
                    
                    <div class="flex flex-col items-center">
                        <!-- DATOS GENERALES -->
                        <div>                
                            <form class="form-control w-full max-w-xs text-sm" @submit.prevent="form.post(route('admin.asignaciones.store'))">

                                <div class="alert alert-info shadow-lg" v-if="form.hasErrors">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <span>Verificar algunos campos del formulario</span>
                                    </div>
                                </div>                    
                                
                                <!-- Selector profesores -->
                                <label class="label" for="profesor">Profesor</label>
                                <select class="select select-sm select-bordered"
                                        :class="{ 'select-error': form.errors.profesor_id }"
                                        name="profesor"
                                        id="profesor" 
                                        v-model="form.profesor_id">
                                    <option disabled value="">Seleccione un profesor</option>
                                    <option v-for="(profesor) in  profesores" 
                                            :key="profesor.id"
                                            :value="profesor.id"
                                    >{{  profesor.apellidos + ' ' + profesor.nombres }}</option>
                                </select>
                                <div class="badge badge-warning"  v-if="form.errors.profesor_id">{{ form.errors.profesor_id }}</div>

                                <!-- Selector asignaturas -->
                                <label class="label" for="asignatura">Asignatura</label>
                                <select class="select select-sm select-bordered"
                                        :class="{ 'select-error': form.errors.asignatura_id }"
                                        name="asignatura"
                                        id="asignatura" 
                                        v-model="form.asignatura_id">
                                    <option disabled value="">Seleccione una asignatura</option>
                                    <option v-for="(asignatura) in  asignaturas" 
                                            :key="asignatura.id"
                                            :value="asignatura.id"
                                    >{{  asignatura.nombre }}</option>
                                </select>
                                <div class="badge badge-warning"  v-if="form.errors.asignatura_id">{{ form.errors.asignatura_id }}</div>

                                <!-- Selector grupos -->
                                <label class="label" for="grupo">Grupo</label>
                                <select class="select select-sm select-bordered"
                                        :class="{ 'select-error': form.errors.grupo_id }"
                                        name="grupo"
                                        id="grupo" 
                                        v-model="form.grupo_id" multiple>
                                    <option disabled value="">Seleccione uno o varios grupos</option>
                                    <option v-for="(grupo) in  grupos" 
                                            :key="grupo.id"
                                            :value="grupo.id"
                                    >{{  grupo.nombre }}</option>
                                </select>
                                <div class="badge badge-warning"  v-if="form.errors.grupo_id">{{ form.errors.grupo_id }}</div>

                                <label class="label" for="ih">Intensidad horaria</label>
                                <input type="number" id="ih" class="input input-sm input-bordered w-full max-w-xs" :class="{ 'input-error': form.errors.intensidad_horaria }" min="0" max="99" v-model="form.intensidad_horaria">
                                <div class="badge badge-warning"  v-if="form.errors.intensidad_horaria">{{ form.errors.intensidad_horaria }}</div>
                                                                
                                <div class="flex justify-end space-x-2 mt-2">
                                    <button type="submit" class="btn btn-primary" :disabled="form.processing">Guardar</button>
                                    <Link class="btn btn-outline btn-primary" :href="route('admin.asignaciones.index')" >Cancelar</Link>
                                </div>               
                            </form>                
                        </div>
                    </div>        
                </div>
            </div>
        </div>
    </AppLayout>
</template>


<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const props = defineProps({    
    profesores: Array,    
    grupos: Array,
    asignaturas:Array,
});

const title = ref('Crear Asignación Académica');

const form = useForm({
    intensidad_horaria:null,
    profesor_id:null,
    asignatura_id:null,
    grupo_id:[],    
});

</script>