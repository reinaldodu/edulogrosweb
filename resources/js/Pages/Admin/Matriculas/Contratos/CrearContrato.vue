<template>
    <AppLayout title="Crear Contrato">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">
            <div class="card w-xs bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Crear Contrato</h2>
                    
                    <div class="flex flex-col items-center">
                        <div>                
                            <form class="form-control w-full max-w-xs text-sm" @submit.prevent="form.post(route('admin.contratos.store'))"> 
                               
                                <label class="label" for="nombre">Nombre*</label>
                                <input type="text" id="nombre"
                                                    class="input input-sm input-bordered w-full max-w-xs"
                                                    :class="{ 'input-error': form.errors.nombre }"
                                                    v-model="form.nombre">
                                <div class="badge badge-warning"  v-if="form.errors.nombre">{{ form.errors.nombre }}</div>

                                <label class="label" for="descripcion">Descripción</label>
                                <input type="text" id="descripcion" class="input input-sm input-bordered w-full max-w-xs" v-model="form.descripcion">
                                
                                <label class="label" for="plantilla">Plantilla contrato (formato .docx)</label>
                                <input class="mt-2 block w-full text-sm text-slate-500
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-full file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-violet-50 file:text-violet-700
                                            hover:file:bg-violet-100"
                                        type="file"
                                        id="plantilla"
                                        name="plantilla"
                                        @input="form.plantilla = $event.target.files[0]" />
                                <progress v-if="form.progress" class="progress w-56" :value="form.progress.percentage" max="100">
                                {{ form.progress.percentage }}%
                                </progress>
                                <div class="badge badge-warning"  v-if="form.errors.plantilla">{{ form.errors.plantilla }}</div>

                                <div class="flex justify-end space-x-2 mt-5">
                                    <button type="submit" class="btn btn-primary" :disabled="form.processing">Guardar</button>
                                    <Link class="btn btn-outline btn-primary" :href="route('admin.contratos.index')" >Cancelar</Link>
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

const title = ref('Crear Contrato');

const form = useForm({    
    nombre:null,
    descripcion:null,
    plantilla:null,
});

</script>