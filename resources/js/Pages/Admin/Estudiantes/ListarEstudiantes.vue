<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        
        <div class="py-12">
            
            <div class="flex justify-between">
                <!-- Buscar estudiante -->
                <div class="ml-10">
                    <div>
                        <div class="input-group">
                            <input type="text" placeholder="Buscar por nombres o apellidos..."
                            class="input input-sm input-bordered w-60"
                            v-model="search"
                            @keyup.enter="searchEstudiante"
                             />
                            <Link :href="route('admin.estudiantes.index') + '?search=' + search" class="btn btn-sm btn-square">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </Link>
                        </div>
                    </div>
                </div>
                
                <div class="mr-5 mb-5 flex space-x-2">
                    <!-- Descargar estudiantes en excel -->
                    <a :href="route('admin.estudiantes.exportar.excel')" class="btn btn-outline btn-xs normal-case" >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg> Excel
                    </a>
                    <!-- Crear estudiante -->
                    <Link class="btn btn-xs" :href="route('admin.estudiantes.create')">
                        Crear Estudiante
                    </Link>
                </div>
            </div>
            
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="w-full mb-20">  
                        <table class="table table-zebra w-full mb-5">
                            <thead>
                                <tr>           
                                    <th>Nombre</th>
                                    <th>Documento</th>                                
                                    <th>F_Nacimiento</th>
                                    <th>Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                <tr v-for="(estudiante,i) in  estudiantes.data" :key="i">
                                    <td>
                                        <div class="flex items-center space-x-3">
                                            <div class="avatar">
                                                <div class="mask mask-squircle w-12 h-12">
                                                    <img :src="estudiante.foto ? estudiante.foto : '/storage/images/sin_foto.png'" alt="Foto del estudiante">
                                                </div>
                                            </div>
                                            <div>
                                                <div>
                                                    <Link class="font-bold btn-ghost rounded-lg" :href="route('admin.estudiantes.show', estudiante.id)">
                                                        {{ estudiante.apellidos + ' ' + estudiante.nombres }}
                                                    </Link>
                                                </div>
                                                <div class="text-sm opacity-50">{{ estudiante.grados[0].nombre }}</div>
                                                <div :class="classEstado(estudiante.grados[0].pivot.estado_id, estudiante.grupos)">{{ estadoEstudiante(estudiante.grados[0].pivot.estado_id, estudiante.grupos) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ estudiante.documento }}</td>
                                    <td>
                                        {{ estudiante.fecha_nacimiento }} <span class="text-xs"> - {{ estudiante.edad }} años</span>
                                        <br><span class="badge badge-ghost badge-sm">{{ estudiante.pais.nombre }}</span>
                                    </td>
                                    <td>{{ estudiante.user.email }}</td>
                                    <td>
                                        <div class="dropdown dropdown-left">
                                                <label tabindex="0" class="btn btn-ghost btn-xs m-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                    </svg>
                                                </label>
                                                <ul tabindex="0" class="dropdown-content menu menu-compact p-2 shadow bg-base-100 rounded-box w-52">
                                                    <li>
                                                        <Link :href="route('admin.estudiantes.edit', estudiante.id)">
                                                            Editar
                                                        </Link>
                                                    </li>
                                                    <li v-if="!estudiante.grupos_exists && !estudiante.notas_logros_exists && !estudiante.notas_generales_exists && !estudiante.observaciones_exists && !estudiante.asistencias_exists">
                                                        <label for="modal-elimina" @click="dataStudent=estudiante">
                                                            Eliminar
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <Link :href="route('admin.usuarios.edit', estudiante.user_id)">
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
                    <pagination :links="estudiantes.links" />
                </div>
            </div>
        </div>
    </AppLayout>
    
    <!-- Modal Eliminar estudiante -->
    <input type="checkbox" id="modal-elimina" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Eliminar estudiante</h3>
            <p class="py-4">¿Desea eliminar el estudiante {{ dataStudent.apellidos + ' ' + dataStudent.nombres }}?</p>
            <div class="modal-action">
                <label @click="eliminar_estudiante(dataStudent.id)" for="modal-elimina" class="btn">Si</label>
                <label for="modal-elimina" class="btn">No</label>
            </div>
        </div>
    </div>
</template>


<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Inertia } from '@inertiajs/inertia';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';

const props = defineProps({
    estudiantes: Object,
    estados: Object,
});

const title = ref('Lista de Estudiantes');
const search = ref('');
const dataStudent = ref({});

const searchEstudiante = () => {
    Inertia.visit(route('admin.estudiantes.index') + '?search=' + search.value);
};

const classEstado = (id,grupo) => {
    if (id == 1) {
         // Verificar si el estudiante tiene grupo asignado
        if (grupo.length > 0) {
            return 'text-xs badge badge-outline';
        } else {
            return 'text-xs badge badge-outline badge-error';
        } 
    } 
    if (id == 2) {
        return 'text-xs badge badge-warning';
    } 
    if (id == 3) {
        return 'text-xs badge badge-outline badge-info';
    }
};

const estadoEstudiante = (id,grupo) => {  //argumentos: id del estado, grupo del estudiante
    if (id === 1) {
        // Verificar si el estudiante tiene grupo asignado
        if (grupo.length > 0) {
            return grupo[0].nombre.toLowerCase();
        } else {
            return 'Sin grupo';
        }
    } 
    if (id === 2) {
        return props.estados[1].nombre;
    }
    if (id === 3) {
        return props.estados[2].nombre;
    }
};

function eliminar_estudiante(id)
{
    Inertia.delete(route('admin.estudiantes.destroy', id));
}
    
</script>