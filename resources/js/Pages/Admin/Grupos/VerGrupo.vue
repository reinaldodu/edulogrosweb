<template>
    <AppLayout title="Grupos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title.toUpperCase() }}
            </h2>
        </template>
        <div class="py-12">

            <div v-if="!verDisponibles" class="card w-xs bg-base-100 shadow-xl">        
                <div class="card-body">
                    <h2 class="card-title justify-center">{{ grupo.nombre }} - {{ grupo.descripcion }}</h2>
                        <div>
                            <p><span class="font-semibold">Director:</span>
                                {{ grupo.director.apellidos + ' ' + grupo.director.nombres }}
                            </p>
                            <p v-if="grupo.codirector"><span class="font-semibold">Codirector:</span>
                                {{ grupo.codirector.apellidos + ' ' + grupo.codirector.nombres }}
                            </p>
                            <p><span class="font-semibold">Grado:</span>
                                {{ grupo.grado.nombre }}
                            </p>
                        </div>
                        <!--Muestra el botón agregar estudiantes si existen estudiantes disponibles en el grado-->
                        <div v-if="disponibles.length > 0" class="flex justify-end mb-2">
                            <button  
                                class="btn btn-xs rounded-full mt-2"
                                @click="verDisponibles=true">Agregar estudiantes
                            </button>
                        </div> 
                        <div class="overflow-x-auto w-full">  
                            <table class="table table-zebra table-compact w-full">
                                <thead>
                                    <tr>
                                        <th class="w-5"></th>
                                        <th>Apellidos y nombres del estudiante</th>                                    
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                <tr v-for="(estudiante,indice) in  grupo.estudiantes" :key="indice">                            
                                    <th>{{ indice+1 }}</th>
                                    <td>{{ estudiante.apellidos + ' ' + estudiante.nombres }}</td>
                                    <td>
                                        <div class="tooltip tooltip-left" :data-tip="'Retirar ' + estudiante.apellidos + ' ' + estudiante.nombres">
                                            <label class="btn btn-ghost btn-xs modal-button" for="my-modal" @click="info_estudiante=estudiante">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--ic" width="16" height="16" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="#888888" d="M10.09 15.59L11.5 17l5-5l-5-5l-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM21 3H3v6h2V5h14v14H5v-4H3v6h18V3z"></path></svg>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>                    
                </div>        
            </div>
            <div v-if="verDisponibles">
                <AgregarEstudiante :grupo="grupo" :estudiantes="disponibles" />
            </div>
        </div>
    </AppLayout>

     <!-- Modal Eliminar estudiante del grupo -->
    <input type="checkbox" id="my-modal" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Retirar Estudiante</h3>
            <p class="py-4">¿Desea retirar el estudiante {{ info_estudiante.apellidos + ' ' + info_estudiante.nombres }}?</p>
            <div class="modal-action">
                <label @click="eliminaEstudiante(info_estudiante.id)" for="my-modal" class="btn">Si</label>
                <label for="my-modal" class="btn">No</label>
            </div>
        </div>
    </div>

</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import AgregarEstudiante from '@/Pages/Admin/Grupos/AgregarEstudiante.vue';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-vue3';
import { provide, ref } from 'vue';
const props = defineProps({
    grupo:Object,
    disponibles: Object,  //Estudiantes disponibles para agregar al grupo y que pertenecen al mismo grado
});

const title = ref('Grupo ' + props.grupo.nombre);

// Para mostrar/ocultar la ventana de estudiantes disponibles
const verDisponibles = ref(false);
provide('verDisponibles',verDisponibles);

const info_estudiante = ref({});

function eliminaEstudiante(id)
{
    Inertia.delete(route('admin.grupos.deletestudent',{ grupo:props.grupo.id, estudiante:id }));
}

</script>
