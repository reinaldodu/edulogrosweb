<template>
    <div class="card w-xs bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title text-sm">Editar Asignatura</h2>
            
            <div class="flex flex-col items-center">                    
                <div>                
                    <form class="form-control w-full max-w-xs text-xs" @submit.prevent="form.put(route('admin.asignaturas.update', form.id), { onSuccess: () => visible=false })">
                        
                        <label class="label" for="nombre">Nombre*</label>
                        <input type="text" id="nombre" class="input input-sm input-bordered w-full max-w-xs" :class="{ 'input-error': form.errors.nombre }" v-model="form.nombre">
                        <div class="badge badge-warning"  v-if="form.errors.nombre">{{ form.errors.nombre }}</div>

                        <label class="label" for="descripcion">Descripción</label>
                        <input type="text" id="descripcion" class="input input-sm input-bordered w-full max-w-xs" v-model="form.descripcion">
                        
                        <label v-if="asignatura.asignaciones.length==0" class="link link-accent py-2"  for="my-modal">Eliminar asignatura</label>

                        <div class="flex justify-end space-x-2 mt-2">
                            <button type="submit" class="btn btn-primary btn-xs" :disabled="form.processing">Guardar</button>
                            <button class="btn btn-outline btn-primary btn-xs" @click.prevent="visible=false">Cancelar</button>
                        </div>               
                    </form>                
                </div>            
            </div>        
        </div>
    </div>

    <!-- Modal Eliminar asignatura -->
    <input type="checkbox" id="my-modal" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Eliminar Asignatura</h3>
            <p class="py-4">¿Desea eliminar la asignatura {{ asignatura.nombre }}?</p>
            <div class="modal-action">
                <label @click="elimina_asignatura" for="my-modal" class="btn">Si</label>
                <label for="my-modal" class="btn">No</label>
            </div>
        </div>
    </div>   

</template>


<script setup>
import { Inertia } from '@inertiajs/inertia';
import { useForm, Link } from '@inertiajs/inertia-vue3';
import { inject } from '@vue/runtime-core';

const props = defineProps({
    asignatura: Object,
});

const visible = inject('FormEditaAsignatura');

const form = useForm({    
    id: props.asignatura.id,
    nombre:props.asignatura.nombre,
    descripcion:props.asignatura.descripcion,
    area_id:props.asignatura.area_id,
});

function elimina_asignatura()
{
    Inertia.delete(route('admin.asignaturas.destroy', form.id));
    visible.value=false;
}

</script>