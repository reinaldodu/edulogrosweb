<template>
    <AppLayout title="Sistema evaluación">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">
            <div class="card w-xs bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Crear evaluación por grado</h2>        
                    
                    <div class="flex flex-col items-center">
                        <!-- DATOS GENERALES -->
                        <div>                
                            <form class="form-control w-full max-w-xs text-sm" @submit.prevent="form.post(route('admin.sistema-evaluacion.store'))">

                                <div class="alert alert-info shadow-lg" v-if="form.hasErrors">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <span>Verificar algunos campos del formulario</span>
                                    </div>
                                </div>                    
                                
                                <!-- Selector grados -->
                                <label class="label" for="grado">Grado</label>
                                <select class="select select-sm select-bordered"
                                        :class="{ 'select-error': form.errors.grado_id }"
                                        name="grado"
                                        id="grado" 
                                        v-model="form.grado_id" multiple>
                                    <option disabled value="">Seleccione uno o varios grados</option>
                                    <option v-for="(grado) in  grados" 
                                            :key="grado.id"
                                            :value="grado.id"
                                    >{{  grado.nombre }}</option>
                                </select>
                                <div class="badge badge-warning"  v-if="form.errors.grado_id">{{ form.errors.grado_id }}</div>
                                
                                <!-- Selector tipos de evaluacion -->
                                <label class="label" for="tipo">Tipo evalución</label>
                                <select class="select select-sm select-bordered"
                                        :class="{ 'select-error': form.errors.tipo_evaluacion_id }"
                                        name="tipo"
                                        id="tipo" 
                                        v-model="form.tipo_evaluacion_id">
                                    <option disabled value="">Seleccione un tipo de evaluación</option>
                                    <option v-for="(tipo) in  tipos" 
                                            :key="tipo.id"
                                            :value="tipo.id"
                                    >{{  tipo.nombre }}</option>
                                </select>
                                <div class="badge badge-warning"  v-if="form.errors.tipo_evaluacion_id">{{ form.errors.tipo_evaluacion_id }}</div>

                                <label class="label" for="porcentaje">Porcentaje</label>
                                <input type="number" id="porcentaje" class="input input-sm input-bordered w-full max-w-xs" 
                                                                     :class="{ 'input-error': form.errors.porcentaje }" 
                                                                     min="1" 
                                                                     max="100" 
                                                                     v-model="form.porcentaje">
                                <div class="badge badge-warning"  v-if="form.errors.porcentaje">{{ form.errors.porcentaje }}</div>

                                <!-- Check para habilitar la creación de actividades para evaluar por cada tipo de evaluación -->
                                <div class="flex mt-4 mb-5 items-center">
                                    <span class="text-xs mr-2">El profesor puede crear actividades para evaluar</span>
                                    <input type="checkbox" class="checkbox checkbox-xs" v-model="form.evalua_actividades" />
                                </div>
                                                                
                                <div class="flex justify-end space-x-2 mt-2">
                                    <button type="submit" class="btn btn-primary" :disabled="form.processing">Guardar</button>
                                    <Link class="btn btn-outline btn-primary" :href="route('admin.sistema-evaluacion.index')" >Cancelar</Link>
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
    grados: Array,    
    tipos: Array,
});

const title = ref('Sistema de evaluación');

const form = useForm({
    grado_id:[],
    tipo_evaluacion_id:'',
    porcentaje:null,
    evalua_actividades:false
});

</script>