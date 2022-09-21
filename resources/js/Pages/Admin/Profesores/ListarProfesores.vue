<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        
        <div class="py-12">
            <div class="flex justify-end px-4 mb-3">
                <Link class="btn btn-primary btn-xs" :href="route('admin.profesores.create')">
                    Crear Profesor
                </Link>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="overflow-x-auto w-full">  
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
                                    <div class="font-bold">{{ profesor.apellidos + ' ' + profesor.nombres }}</div>
                                    <div class="text-sm opacity-50">{{ profesor.profesion }}</div>
                                    </div>
                                </div>
                            </td>                            
                            <td>{{ profesor.documento }}</td>
                            <td>{{ profesor.cargo }}</td>                            
                            <td>{{ profesor.user.email }}</td>
                            <td class="px-4 py-2">
                                <Link class="btn btn-ghost btn-xs" :href="route('admin.profesores.show', profesor.id)">
                                    Ver
                                </Link>
                                <Link class="btn btn-ghost btn-xs" :href="route('admin.profesores.edit', profesor.id)">
                                    Editar
                                </Link>
                                <a class="btn btn-ghost btn-xs" @click.prevent="eliminar_profesor(profesor.id)">
                                    Eliminar
                                </a>
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

function eliminar_profesor(id)
{
    if (confirm('¿Desea eliminar el profesor del sistema?')) {        
        Inertia.delete(route('admin.profesores.destroy', id));
    }
}
    
</script>