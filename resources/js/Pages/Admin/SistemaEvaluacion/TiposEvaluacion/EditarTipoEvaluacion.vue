<template>
    <AppLayout title="Tipos de evaluación">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">
            <div class="card w-xs bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-sm">Editar tipo de evaluación</h2>
                    
                    <div class="flex flex-col items-center">                    
                        <div>                
                            <form class="form-control w-full max-w-xs text-xs" @submit.prevent="form.put(route('admin.tipo-evaluaciones.update', form.id))">
                                
                                <label class="label" for="nombre">Nombre*</label>
                                <input type="text" id="nombre" class="input input-sm input-bordered w-full max-w-xs" :class="{ 'input-error': form.errors.nombre }" v-model="form.nombre">
                                <div class="badge badge-warning"  v-if="form.errors.nombre">{{ form.errors.nombre }}</div>

                                <label class="label" for="abreviatura">abreviatura*</label>
                                <input type="text" id="abreviatura" class="input input-sm input-bordered w-full max-w-xs" :class="{ 'input-error': form.errors.abreviatura }" v-model="form.abreviatura">
                                <div class="badge badge-warning"  v-if="form.errors.abreviatura">{{ form.errors.abreviatura }}</div>
                                                                
                                <div class="flex justify-end space-x-2 mt-5">
                                    <button type="submit" class="btn btn-primary" :disabled="form.processing">Guardar</button>
                                    <Link class="btn btn-outline btn-primary" :href="route('admin.tipo-evaluaciones.index')" >Cancelar</Link>
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

const title = ref('Tipos de evaluación');

const props = defineProps({
    tipo: Object,
});

const form = useForm({    
    id: props.tipo.id,
    nombre: props.tipo.nombre,
    abreviatura: props.tipo.abreviatura,
});

</script>