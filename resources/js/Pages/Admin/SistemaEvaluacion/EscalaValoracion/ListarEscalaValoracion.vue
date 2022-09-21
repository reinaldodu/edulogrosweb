<template>
    <AppLayout title="Escala de valoración">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        
        <div class="py-12">
            <div class="flex justify-end px-4 mb-3 space-x-4">
                <Link class="btn btn-xs" :href="route('admin.escala-valoracion.create')">
                    Agregar escala de valoración
                </Link>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="overflow-x-auto w-full">  
                        <table class="table table-compact table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>Grado</th>
                                    <th>Nombre</th>
                                    <th>Abreviatura</th>
                                    <th>Rango inicial</th>
                                    <th>Rango final</th>
                                    <th>Imagen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                            <tr v-for="(escala,i) in  escalas.data" :key="i">                            
                                <td>{{ escala.grado.nombre }}</td>
                                <td>{{ escala.nombre }}</td>
                                <td>{{ escala.abreviatura }}</td>
                                <td>{{ escala.rango_inicial }}</td>
                                <td>{{ escala.rango_final }}</td>
                                <td>
                                    <img v-if="escala.imagen" :src="escala.url_imagen" class="w-10 rounded-full" alt="imagen escala">
                                </td>

                                <td >
                                    <div class="tooltip tooltip-left" data-tip="Editar">
                                        <Link class="btn btn-square btn-ghost btn-xs" :href="route('admin.escala-valoracion.edit', escala.id)">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--ic" width="16" height="16" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="#888888" d="m14.06 9.02l.92.92L5.92 19H5v-.92l9.06-9.06M17.66 3c-.25 0-.51.1-.7.29l-1.83 1.83l3.75 3.75l1.83-1.83a.996.996 0 0 0 0-1.41l-2.34-2.34c-.2-.2-.45-.29-.71-.29zm-3.6 3.19L3 17.25V21h3.75L17.81 9.94l-3.75-3.75z"></path></svg>
                                        </Link>
                                    </div>
                                    <div class="tooltip tooltip-left" data-tip="Eliminar">
                                        <label class="btn btn-ghost btn-xs modal-button" for="modal-elimina" @click="datosElimina(escala)">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--ic" width="16" height="16" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="#888888" d="M14.12 10.47L12 12.59l-2.13-2.12l-1.41 1.41L10.59 14l-2.12 2.12l1.41 1.41L12 15.41l2.12 2.12l1.41-1.41L13.41 14l2.12-2.12zM15.5 4l-1-1h-5l-1 1H5v2h14V4zM6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9z"></path></svg>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <pagination :links="escalas.links" />
                </div>
            </div>
        </div>
    </AppLayout>

    <!-- Modal Eliminar evaluación -->
    <input type="checkbox" id="modal-elimina" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Eliminar Escala</h3>
            <span class="py-4">Desea eliminar la escala {{ info_escala.nombre }} del grado {{ info_escala.grado }}?</span>
            <div class="modal-action">
                <label for="modal-elimina" @click="eliminaEscala(info_escala.id)" class="btn">Si</label>
                <label for="modal-elimina" class="btn">No</label>
            </div>
        </div>
    </div>   


</template>


<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    escalas: Object,
});

const title = ref('Escala de valoración');

// variable que guarda el valor de una escala para eliminar
const info_escala = ref({
    id: '',
    nombre: '',
    grado: '',
});

function datosElimina(data) {
    info_escala.value.id = data.id;
    info_escala.value.nombre = data.nombre;
    info_escala.value.grado = data.grado.nombre;
}

function eliminaEscala(id)
{
    Inertia.delete(route('admin.escala-valoracion.destroy', id));
}

</script>