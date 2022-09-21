<template>
    <AppLayout title="Crear Area">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">
            <div class="card w-xs bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Crear Área</h2>
                    
                    <div class="flex flex-col items-center">
                        <!-- DATOS GENERALES -->
                        <div>                
                            <form class="form-control w-full max-w-xs text-sm" @submit.prevent="form.post(route('admin.areas.store'))">
                               
                                <label class="label" for="nombre">Nombre*</label>
                                <input type="text" id="nombre" class="input input-sm input-bordered w-full max-w-xs" :class="{ 'input-error': form.errors.nombre }" v-model="form.nombre">
                                <div class="badge badge-warning"  v-if="form.errors.nombre">{{ form.errors.nombre }}</div>

                                <label class="label" for="descripcion">Descripción</label>
                                <input type="text" id="descripcion" class="input input-sm input-bordered w-full max-w-xs" v-model="form.descripcion">
                                                                
                                <div class="flex justify-end space-x-2 mt-5">
                                    <button type="submit" class="btn btn-primary" :disabled="form.processing">Guardar</button>
                                    <Link class="btn btn-outline btn-primary" :href="route('admin.areas.index')" >Cancelar</Link>
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

const title = ref('Crear Área');

const form = useForm({    
    nombre:'',
    descripcion:''
});

</script>