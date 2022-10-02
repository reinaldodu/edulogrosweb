<template>
    <AppLayout title="Periodos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        
        <div class="py-12">
            <div class="flex justify-end px-4 mb-3">
                <Link class="btn btn-xs" :href="route('admin.periodos.create')">
                    Crear Periodo
                </Link>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="overflow-x-auto w-full">  
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Abreviatura</th>
                                    <th>Fecha de inicio</th>
                                    <th>Fecha de finalización</th>
                                    <th>Porcentaje</th>
                                    <th>Activo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                            <tr v-for="(periodo,i) in  periodos" :key="i">                            
                                <td>{{ periodo.nombre }}</td>
                                <td>{{ periodo.descripcion }}</td>
                                <td>{{ periodo.abreviatura }}</td>
                                <td>{{ periodo.fecha_inicio }}</td>
                                <td>{{ periodo.fecha_fin }}</td>                                
                                <td>{{ periodo.porcentaje }}%</td>
                                <td>{{ periodo.activo }}</td>
                                <td >
                                    <div class="tooltip tooltip-left" :data-tip="'Editar ' + periodo.nombre">
                                        <Link class="btn btn-square btn-ghost btn-xs" :href="route('admin.periodos.edit', periodo.id)">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--ic" width="16" height="16" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="#888888" d="m14.06 9.02l.92.92L5.92 19H5v-.92l9.06-9.06M17.66 3c-.25 0-.51.1-.7.29l-1.83 1.83l3.75 3.75l1.83-1.83a.996.996 0 0 0 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29zm-3.6 3.19L3 17.25V21h3.75L17.81 9.94l-3.75-3.75z"></path></svg>
                                        </Link>
                                    </div>
                                    <div v-if="periodo.logros_count===0 && periodo.notas_generales_count===0 && periodo.actividades_generales_count===0 " class="tooltip tooltip-left" :data-tip="'Eliminar ' + periodo.nombre">
                                        <label class="btn btn-ghost btn-xs modal-button" for="my-modal" @click="info_periodo.nombre=periodo.nombre; info_periodo.id=periodo.id">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--ic" width="16" height="16" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="#888888" d="M14.12 10.47L12 12.59l-2.13-2.12l-1.41 1.41L10.59 14l-2.12 2.12l1.41 1.41L12 15.41l2.12 2.12l1.41-1.41L13.41 14l2.12-2.12zM15.5 4l-1-1h-5l-1 1H5v2h14V4zM6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9z"></path></svg>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

    <!-- Modal Eliminar periodo -->
    <input type="checkbox" id="my-modal" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Eliminar periodo</h3>
            <p class="py-4">¿Desea eliminar el periodo {{ info_periodo.nombre }}?</p>
            <div class="modal-action">
                <label @click="eliminar_periodo(info_periodo.id)" for="my-modal" class="btn">Si</label>
                <label for="my-modal" class="btn">No</label>
            </div>
        </div>
    </div>   
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    periodos: Object,
});

const title = ref('Lista de periodos');

const info_periodo = ref({
    id: 0,
    nombre: '',
});

function eliminar_periodo(id)
{
        Inertia.delete(route('admin.periodos.destroy', id));
}

</script>