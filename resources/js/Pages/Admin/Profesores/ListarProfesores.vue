<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        
        <div class="mt-5 mr-5">
            <div class="flex justify-end px-4 mb-3">
                <Link class="btn btn-xs" :href="route('admin.profesores.create')">
                    Crear Profesor
                </Link>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="w-full">  
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>           
                                    <th>Nombre</th>
                                    <th>Documento</th>
                                    <th>Cargo</th>
                                    <th>Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                <tr v-for="(profesor,i) in  profesores.data" :key="i">
                                    <td>
                                        <div class="flex items-center space-x-3">
                                            <div class="avatar">
                                                <div class="mask mask-squircle w-12 h-12">
                                                    <img :src="profesor.foto" alt="foto profesor" />
                                                </div>
                                            </div>
                                            <div>
                                                <div>
                                                    <Link class="font-bold btn-ghost rounded-lg" :href="route('admin.profesores.show', profesor.id)">
                                                        {{ profesor.apellidos + ' ' + profesor.nombres }}
                                                    </Link>
                                                </div>
                                                <div class="text-sm opacity-50">{{ profesor.profesion }}</div>
                                            </div>
                                        </div>
                                    </td>                            
                                    <td>{{ profesor.documento }}</td>
                                    <td>{{ profesor.cargo }}</td>                            
                                    <td>{{ profesor.user.email }}</td>
                                    <td>                                
                                        <div class="dropdown dropdown-left">
                                            <label tabindex="0" class="btn btn-ghost btn-xs m-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                </svg>
                                            </label>
                                            <ul tabindex="0" class="dropdown-content menu menu-compact p-2 shadow bg-base-100 rounded-box w-52">
                                                <li>
                                                    <Link :href="route('admin.profesores.edit', profesor.id)">
                                                        Editar
                                                    </Link>
                                                </li>
                                                <li v-if="profesor.grupo_director_count===0 && profesor.grupo_codirector_count===0 && profesor.asignaciones_count===0">
                                                    <label for="modal-elimina" @click="dataTeacher=profesor">
                                                        Eliminar
                                                    </label>
                                                </li>
                                                <li>
                                                    <Link :href="route('admin.usuarios.edit', profesor.user_id)">
                                                        Opciones de Usuario
                                                    </Link>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <pagination :links="profesores.links" />
                </div>
            </div>
        </div>
    </AppLayout>
    <!-- Modal Eliminar profesor -->
    <input type="checkbox" id="modal-elimina" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Eliminar profesor</h3>
            <p class="py-4">¿Desea eliminar el profesor {{ dataTeacher.apellidos + ' ' + dataTeacher.nombres }}?</p>
            <div class="modal-action">
                <label @click="eliminar_profesor(dataTeacher.id)" for="modal-elimina" class="btn">Si</label>
                <label for="modal-elimina" class="btn">No</label>
            </div>
        </div>
    </div>
</template>


<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

defineProps({
    profesores: Object,
});

const title = ref('Lista de Profesores');
const dataTeacher = ref({});

function eliminar_profesor(id)
{
    Inertia.delete(route('admin.profesores.destroy', id));
}
    
</script>