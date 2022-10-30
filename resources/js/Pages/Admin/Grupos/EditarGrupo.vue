<template>
    <AppLayout title="Crear Grupo">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">
            <div class="card w-xs bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Editar Grupo</h2>
                    
                    <div class="flex flex-col items-center">
                        <!-- DATOS GENERALES -->
                        <div>                
                            <form class="form-control w-full max-w-xs text-sm" @submit.prevent="form.put(route('admin.grupos.update', form.id))">
                               
                                <label class="label" for="nombre">Nombre*</label>
                                <input type="text" id="nombre"
                                                    class="input input-sm input-bordered w-full max-w-xs"
                                                    :class="{ 'input-error': form.errors.nombre }"
                                                    v-model="form.nombre">
                                <div class="badge badge-warning"  v-if="form.errors.nombre">{{ form.errors.nombre }}</div>

                                <label class="label" for="descripcion">Descripción</label>
                                <input type="text" id="descripcion" class="input input-sm input-bordered w-full max-w-xs" v-model="form.descripcion">

                                <!-- Selector grado del grupo -->
                                <label class="label" for="grado">Grado*</label>
                                <select class="select select-sm select-bordered"
                                        :class="{ 'select-error': form.errors.grado_id }"
                                        :disabled="grupo.estudiantes_count > 0"
                                        name="grado" 
                                        id="grado" 
                                        v-model="form.grado_id">
                                    <option disabled value="">Seleccione un grado</option>
                                    <option v-for="(grado) in  grados"
                                            :key="grado.id"
                                            :value="grado.id"                                
                                    >{{  grado.nombre }}</option>
                                </select>
                                <div class="badge badge-warning"  v-if="form.errors.grado_id">{{ form.errors.grado_id }}</div>

                                <!-- Selector director del grupo -->
                                <label class="label" for="director">Director*</label>
                                <select class="select select-sm select-bordered"
                                        :class="{ 'select-error': form.errors.director_id }"
                                        name="director" 
                                        id="director" 
                                        v-model="form.director_id">
                                    <option disabled value="">Seleccione un director</option>
                                    <option v-for="(director) in  profesores" 
                                            :key="director.id"
                                            :value="director.id"
                                    >{{  director.apellidos + ' ' + director.nombres }}</option>
                                </select>
                                <div class="badge badge-warning"  v-if="form.errors.director_id">{{ form.errors.director_id }}</div>

                                <!-- Selector codirector del grupo -->
                                <label class="label" for="codirector">Codirector</label>
                                <select class="select select-sm select-bordered"
                                        :class="{ 'select-error': form.errors.codirector_id }"
                                        name="codirector" 
                                        id="codirector" 
                                        v-model="form.codirector_id">
                                    <option value="">Seleccione un Codirector</option>
                                    <option v-for="(codirector) in  profesores"
                                            :key="codirector.id"
                                            :value="codirector.id"
                                    >{{  codirector.apellidos + ' ' + codirector.nombres }}</option>
                                </select>
                                <div class="badge badge-warning"  v-if="form.errors.codirector_id">{{ form.errors.codirector_id }}</div>

                                <div class="flex justify-end space-x-2 mt-5">
                                    <button type="submit" class="btn btn-primary" :disabled="form.processing">Guardar</button>
                                    <Link class="btn btn-outline btn-primary" :href="route('admin.grupos.index')" >Cancelar</Link>
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

const props = defineProps( {
    grupo:Object,
    grados:Array,
    profesores:Array,
});

const title = ref('Editar Grupo');

const form = useForm({    
    id:props.grupo.id,
    nombre:props.grupo.nombre,
    descripcion:props.grupo.descripcion,
    grado_id:props.grupo.grado_id,
    director_id:props.grupo.director_id,
    codirector_id:props.grupo.codirector_id,
});

</script>