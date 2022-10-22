<template>
    <AppLayout title="Editar tipo asistencia">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">
            <div class="card w-xs bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Editar tipo de asistencia</h2>
                    
                    <div class="flex flex-col items-center">
                        <div>                
                            <form class="form-control w-full max-w-xs text-sm" @submit.prevent="form.put(route('admin.tipo-asistencias.update', form.id))">
                               
                                <label class="label" for="nombre">Nombre*: (máximo: 6 caracteres)</label>
                                <input type="text" id="nombre"
                                                    class="input input-sm input-bordered w-20 max-w-xs"
                                                    :class="{ 'input-error': form.errors.nombre }"
                                                    v-model="form.nombre"
                                                    maxlength="6">
                                <div class="badge badge-warning"  v-if="form.errors.nombre">{{ form.errors.nombre }}</div>

                                <label class="label" for="abreviatura">Abreviatura:</label>
                                <input type="text" id="abreviatura"
                                                    class="input input-sm input-bordered w-20 max-w-xs"
                                                    :class="{ 'input-error': form.errors.abreviatura }"
                                                    v-model="form.abreviatura"
                                                    maxlength="2">
                                <div class="badge badge-warning"  v-if="form.errors.abreviatura">{{ form.errors.abreviatura }}</div>

                                <label class="label" for="color">Color:</label>
                                <input type="color" id="color"
                                                    class="input input-sm input-bordered w-20 max-w-xs"
                                                    :class="{ 'input-error': form.errors.color }"
                                                    v-model="form.color"
                                />
                                <div class="badge badge-warning"  v-if="form.errors.color">{{ form.errors.color }}</div>

                                <div class="flex justify-end space-x-2 mt-4">
                                    <button type="submit" class="btn btn-primary" :disabled="form.processing">Guardar</button>
                                    <Link class="btn btn-outline btn-primary" :href="route('admin.tipo-asistencias.index')" >Cancelar</Link>
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

const props = defineProps(['tipo']);

const title = ref('Editar tipo asistencia');

const form = useForm({    
    id: props.tipo.id,
    nombre: props.tipo.nombre,
    abreviatura: props.tipo.abreviatura,
    color: props.tipo.color,
});

</script>