<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        
        <div class="py-12">
            <div class="flex justify-end px-4 mb-3">
                <Link class="btn btn-xs" :href="route('admin.areas.create')">
                    Crear Area
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
                                <th>Asignaturas</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                        <tr v-for="(area,i) in  areas.data" :key="i">                            
                            <td>
                                <div class="tooltip tooltip-right" :data-tip="'Editar ' + area.nombre">
                                    <Link class="font-semibold btn btn-ghost btn-xs" :href="route('admin.areas.edit', area.id)">
                                        {{ area.nombre }}
                                    </Link>
                                </div>
                            </td>
                            <td>{{ area.descripcion }}</td>
                            <td> 
                                <ul v-for="(asignatura) in area.asignaturas" :key="asignatura.id">
                                    <li>{{ asignatura.nombre }}</li>
                                </ul>
                            </td>                            
                        </tr>
                        </tbody>
                    </table>
                    </div>
                    <pagination :links="areas.links" />
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

const props = defineProps({
    areas: Object,
});
const title = ref('Lista de Áreas');

function eliminar_area(id)
{
    if (confirm('¿Desea eliminar el área del sistema?')) {        
        Inertia.delete(route('admin.areas.destroy', id));
    }
}
    
</script>