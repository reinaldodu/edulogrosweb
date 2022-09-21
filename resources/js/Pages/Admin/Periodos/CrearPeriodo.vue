<template>
    <AppLayout title="Crear Periodo">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        <div class="bg-blue-100 m-10 flex flex-col items-center rounded-md shadow-md p-2">
            <div class="card w-xs bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Crear Periodo</h2>
                    
                    <div class="flex flex-col items-center">
                        <!-- DATOS GENERALES -->
                        <div>                
                            <form class="form-control w-full max-w-xs text-sm" @submit.prevent="form.post(route('admin.periodos.store'))">
                            
                                <div class="alert alert-info shadow-lg" v-if="form.hasErrors">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <span>Verificar algunos campos del formulario</span>
                                    </div>
                                </div>

                                <label class="label" for="nombre">Nombre*</label>
                                <input type="text" id="nombre"
                                                    class="input input-sm input-bordered w-full max-w-xs"
                                                    :class="{ 'input-error': form.errors.nombre }"
                                                    v-model="form.nombre">
                                <div class="badge badge-warning"  v-if="form.errors.nombre">{{ form.errors.nombre }}</div>

                                <label class="label" for="descripcion">Descripción*</label>
                                <input type="text" id="descripcion"
                                                    class="input input-sm input-bordered w-full max-w-xs"
                                                    :class="{ 'input-error': form.errors.descripcion }"
                                                    v-model="form.descripcion">
                                <div class="badge badge-warning"  v-if="form.errors.descripcion">{{ form.errors.descripcion }}</div>

                                <label class="label" for="abreviatura">Abreviatura*</label>
                                <input type="text" id="abreviatura"
                                                    class="input input-sm input-bordered w-full max-w-xs"
                                                    :class="{ 'input-error': form.errors.abreviatura }"
                                                    v-model="form.abreviatura">
                                <div class="badge badge-warning"  v-if="form.errors.abreviatura">{{ form.errors.abreviatura }}</div>

                                <label class="label" for="fecha_inicio">Fecha inicial*</label>
                                <input type="date" id="fecha_inicio"
                                                    class="input input-sm input-bordered w-full max-w-xs"
                                                    :class="{ 'input-error': form.errors.fecha_inicio }"
                                                    v-model="form.fecha_inicio">
                                <div class="badge badge-warning"  v-if="form.errors.fecha_inicio">{{ form.errors.fecha_inicio }}</div>

                                <label class="label" for="fecha_fin">Fecha final*</label>
                                <input type="date" id="fecha_fin"
                                                    class="input input-sm input-bordered w-full max-w-xs"
                                                    :class="{ 'input-error': form.errors.fecha_fin }"
                                                    v-model="form.fecha_fin">
                                <div class="badge badge-warning"  v-if="form.errors.fecha_fin">{{ form.errors.fecha_fin }}</div>

                                <label class="label" for="porcentaje">Porcentaje*</label>
                                <input type="number" id="porcentaje"
                                                    min ="1"
                                                    max ="100"
                                                    step ="0.1"
                                                    class="input input-sm input-bordered w-full max-w-xs"
                                                    :class="{ 'input-error': form.errors.porcentaje }"
                                                    v-model="form.porcentaje">
                                <div class="badge badge-warning"  v-if="form.errors.porcentaje">{{ form.errors.porcentaje }}</div>

                                <label class="label" for="porcentaje">{{ 'Periodo ' + txt_activo(form.activo) }}</label>
                                <input type="checkbox"
                                        class="toggle mb-4"
                                        v-model="form.activo" />

                                <div class="flex justify-end space-x-2 mt-2">
                                    <button type="submit" class="btn btn-primary" :disabled="form.processing">Guardar</button>
                                    <Link class="btn btn-outline btn-primary" :href="route('admin.periodos.index')" >Cancelar</Link>
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

const title = ref('Crear Periodo');

const form = useForm({    
    nombre:null,
    descripcion:null,
    abreviatura:null,
    fecha_inicio:null,
    fecha_fin:null,
    porcentaje:null,
    activo:true,
});

const txt_activo = (valor) => valor ? 'activo' : 'inactivo';

</script>