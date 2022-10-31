<template>
    <AppLayout title="Escala de Valoración">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">
            <div class="card w-xs bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Crear escala de valoración</h2>        
                    
                    <div class="flex flex-col items-center">
                        <div>                
                            <form class="form-control w-full max-w-xs text-sm" @submit.prevent="form.post(route('admin.escala-valoracion.store'))">

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
                                
                                <!--Input nombre-->
                                <label class="label" for="nombre">Nombre:*</label>
                                <input type="text" id="nombre" class="input input-sm input-bordered w-full max-w-xs" 
                                                                     :class="{ 'input-error': form.errors.nombre }" 
                                                                     v-model="form.nombre">
                                <div class="badge badge-warning"  v-if="form.errors.nombre">{{ form.errors.nombre }}</div>

                                <!--Input abreviatura-->
                                <label class="label" for="abreviatura">Abreviatura:*</label>
                                <input type="text" id="abreviatura" class="input input-sm input-bordered w-20 max-w-xs" 
                                                                     :class="{ 'input-error': form.errors.abreviatura }" 
                                                                     maxlength="5"
                                                                     v-model="form.abreviatura">
                                <div class="badge badge-warning"  v-if="form.errors.abreviatura">{{ form.errors.abreviatura }}</div>                               

                                <!--Input rango inicial-->
                                <label class="label" for="rango_inicial">Rango inicial:*</label>
                                <input type="number" id="rango_inicial" class="input input-sm input-bordered w-full max-w-xs" 
                                                                     :class="{ 'input-error': form.errors.rango_inicial }" 
                                                                     v-model="form.rango_inicial">
                                <div class="badge badge-warning"  v-if="form.errors.rango_inicial">{{ form.errors.rango_inicial }}</div>

                                <!--Input rango final-->
                                <label class="label" for="rango_final">Rango final:*</label>
                                <input type="number" id="rango_final" class="input input-sm input-bordered w-full max-w-xs" 
                                                                     :class="{ 'input-error': form.errors.rango_final }" 
                                                                     v-model="form.rango_final">
                                <div class="badge badge-warning"  v-if="form.errors.rango_final">{{ form.errors.rango_final }}</div>

                                <!--Subir imagen - Escala valoración (opcional)-->
                                <fieldset class="border border-solid border-gray-300 p-3 mt-2">
                                    <legend class="ml-2">Imagen escala de valoración (opcional)</legend>    
                                    <input class="mt-2 block w-full text-sm text-slate-500
                                                file:mr-4 file:py-2 file:px-4
                                                file:rounded-full file:border-0
                                                file:text-sm file:font-semibold
                                                file:bg-violet-50 file:text-violet-700
                                                hover:file:bg-violet-100"
                                            type="file"
                                            @input="form.imagen = $event.target.files[0]" />
                                    <progress v-if="form.progress" class="progress w-56" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                    </progress>
                                    <div class="badge badge-warning"  v-if="form.errors.imagen">{{ form.errors.imagen }}</div>
                                </fieldset>
                                
                                <div class="flex justify-end space-x-2 mt-5">
                                    <button type="submit" class="btn btn-primary" :disabled="form.processing">Guardar</button>
                                    <Link class="btn btn-outline btn-primary" :href="route('admin.escala-valoracion.index')" >Cancelar</Link>
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
});

const title = ref('Escala de valoración');

const form = useForm({
    grado_id:[],
    nombre:'',
    abreviatura:'',
    imagen:null,
    rango_inicial:null,
    rango_final:null,
});

</script>