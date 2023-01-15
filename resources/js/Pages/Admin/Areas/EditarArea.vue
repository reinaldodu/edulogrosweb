<template>
    <AppLayout title="Editar Area">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">            
            <div class="flex">
                <div>
                    <div class="card w-xs bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title">Editar Área</h2>        
                            
                            <div class="flex flex-col items-center">
                                <!-- Editar nombre y descripción del área -->
                                <div>                
                                    <form class="form-control w-full max-w-xs text-sm" @submit.prevent="form.put(route('admin.areas.update', form.id))">
                                        
                                        <label class="label" for="nombre">Nombre*</label>
                                        <input type="text" id="nombre" class="input input-sm input-bordered w-full max-w-xs" :class="{ 'input-error': form.errors.nombre }" v-model="form.nombre">
                                        <div class="badge badge-warning"  v-if="form.errors.nombre">{{ form.errors.nombre }}</div>

                                        <label class="label" for="descripcion">Descripción</label>
                                        <input type="text" id="descripcion" class="input input-sm input-bordered w-full max-w-xs" v-model="form.descripcion">

                                        <div v-if="area.asignaturas.length==0" class="flex justify-end">
                                            <label class="link link-accent py-2"  for="my-modal">Eliminar área</label>
                                        </div>                            
                                                                        
                                        <div class="flex justify-end space-x-2 mt-5">
                                            <button type="submit" class="btn btn-primary" :disabled="form.processing">Guardar</button>
                                            <Link :href="route('admin.areas.index')" class="btn btn-outline btn-primary">Cancelar</Link>                                           
                                            
                                        </div>               
                                    </form>                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Lista de asignaturas -->
                <div v-if="!FormEditaAsignatura && !FormCreaAsignatura">
                    <div class="card w-60 shadow-xl bg-green-100 ml-5">
                        <div class="card-body">
                            <h2 class="card-title">Asignaturas</h2>
                            <span v-if="area.asignaturas==0">Sin asignaturas</span>
                            <div v-for="(asignatura) in area.asignaturas" :key="asignatura.id">
                                <div class="tooltip tooltip-info tooltip-top" :data-tip="'Editar ' + asignatura.nombre">
                                    <button class="link" for="my-modal2" @click="edita_asignatura(asignatura)">{{ asignatura.nombre }}</button>
                                </div>
                            </div>
                            <div class="card-actions justify-end">
                                <div class="tooltip tooltip-left" data-tip="Agregar asignatura">
                                    <button class="btn btn-circle btn-sm" @click="FormEditaAsignatura=false; FormCreaAsignatura=true;">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /> </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>                   
                </div>
                <div class="ml-5">
                    <CrearAsignatura v-if="FormCreaAsignatura" :area_id="area.id" />
                    <EditarAsignatura v-if="FormEditaAsignatura" :asignatura="info_asignatura" />
                </div>
            </div>
           
            <!-- Modal Eliminar área -->
            <input type="checkbox" id="my-modal" class="modal-toggle" />
            <div class="modal modal-bottom sm:modal-middle">
                <div class="modal-box">
                    <h3 class="font-bold text-lg">Eliminar Area</h3>
                    <p class="py-4">¿Desea eliminar el área {{ area.nombre }}?</p>
                    <div class="modal-action">
                        <label @click="elimina_area" for="my-modal" class="btn">Si</label>
                        <label for="my-modal" class="btn">No</label>
                    </div>
                </div>
            </div>   

        </div>
    </AppLayout>
</template>

<script setup>
import CrearAsignatura from "@/Pages/Admin/Asignaturas/CrearAsignatura.vue";
import EditarAsignatura from "@/Pages/Admin/Asignaturas/EditarAsignatura.vue";
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { provide, ref } from 'vue';

const props = defineProps({
    area: Object,
});

const title = ref('Editar Área ' + props.area.nombre);

const info_asignatura = ref({});

//Valores booleanos para ocultar o mostrar los formularios de crear/editar asignatura
const FormEditaAsignatura = ref(false);
const FormCreaAsignatura = ref(false);

provide('FormCreaAsignatura', FormCreaAsignatura);
provide('FormEditaAsignatura', FormEditaAsignatura);

const form = useForm({
    id: props.area.id,    
    nombre:props.area.nombre,
    descripcion:props.area.descripcion,    
});

const edita_asignatura = (data) => {
    FormCreaAsignatura.value=false;
    FormEditaAsignatura.value=true;
    info_asignatura.value=data;
    //ocultar modal eliminar
    document.getElementById('my-modal').checked=false;
}

function elimina_area()
{
    Inertia.delete(route('admin.areas.destroy', form.id));    
}

</script>