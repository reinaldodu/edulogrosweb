<template>
    <div class="card w-xs bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title text-sm">Crear Asignatura</h2>
            
            <div class="flex flex-col items-center">                    
                <div>                
                    <form class="form-control w-full max-w-xs text-xs" @submit.prevent="form.post(route('admin.asignaturas.store'), { onSuccess: () => visible=false })">
                        
                        <label class="label" for="nombre">Nombre*</label>
                        <input type="text" id="nombre" class="input input-sm input-bordered w-full max-w-xs" :class="{ 'input-error': form.errors.nombre }" v-model="form.nombre">
                        <div class="badge badge-warning"  v-if="form.errors.nombre">{{ form.errors.nombre }}</div>

                        <label class="label" for="descripcion">Descripción</label>
                        <input type="text" id="descripcion" class="input input-sm input-bordered w-full max-w-xs" v-model="form.descripcion">
                                                        
                        <div class="flex justify-end space-x-2 mt-5">
                            <button type="submit" class="btn btn-primary btn-xs" :disabled="form.processing">Guardar</button>
                            <button class="btn btn-outline btn-primary btn-xs" @click.prevent="visible=false" >Cancelar</button>
                        </div>               
                    </form>                
                </div>            
            </div>        
        </div>
    </div>
</template>


<script setup>
import { useForm, Link } from '@inertiajs/inertia-vue3';
import { inject } from '@vue/runtime-core';

const props = defineProps({
    area_id: Number,    
});

const visible = inject('FormCreaAsignatura');

const form = useForm({    
    nombre:'',
    descripcion:'',
    area_id:props.area_id
});

</script>